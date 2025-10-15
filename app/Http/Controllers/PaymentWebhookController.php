<?php

namespace App\Http\Controllers;

use App\Models\CarValuationReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use App\Services\Payments\PaymentService;
use App\Services\CarValuationService;


class PaymentWebhookController extends Controller
{

    public function __construct(private PaymentService $paymentService, private CarValuationService $valuationService)
    {
        // Optionally apply middleware for security, e.g., verify webhook signature
        // $this->middleware('verify.webhook.signature');
    }
    public function handle(Request $request)
    {
        $invoiceId =  $request->get('invoiceId');
        $customerRef = $request->get('customerReferenceNumber');
        $returnUrl = $request->get('returnUrl');

        $status = $this->paymentService->paymentCallback($request);



        if (!$invoiceId || !$customerRef) {
            Log::error('Payment webhook received without required data', $request->all());
            if ($returnUrl) {
                return Redirect::to($returnUrl)->with('error', 'Payment processing failed. Please try again.');
            }
            return response()->json(['error' => 'Missing required data'], 400);
        }

        try {
            // $report = CarValuationReport::where('reference', $customerRef)->firstOrFail();
            $report = CarValuationReport::where('reference', $customerRef)->first();
            
            
            // dd($status->getResponse()['paymentStatus']);

            // Update report payment status based on webhook data
            switch ($status->getResponse()['paymentStatus']) {
                case 'completed':
                    $report->payment_status = 'completed';
                    $report->paid_at = now();
                    $report->payment_data = [
                        'invoice_id' => $invoiceId,
                        'auth_code' => $request->input('authCode'),
                        'card_number' => $request->input('cardNumber'),
                        'amount' => $request->input('amount'),
                        'payment_method' => $request->input('paymentMethod')
                    ];
                    
                    $valuation = $this->valuationService->getValuation(
                        $report->make,
                        $report->model,
                        $report->year,
                        $report->additional_data['mileage'] ?? null
                    );
                    // dd($valuation);
                    $report->min_value = $valuation['min'] ?? null;
                    $report->max_value = $valuation['max'] ?? null;
                    $report->average_value = ($valuation['min'] * 0.4 + $valuation['max'] * 0.6) ?? null;
                    $report->save();
                   
                        return Redirect::to(route('car-valuation.payment-success', ['report' => $report]));
                    
                    break;
                
                case 'canceled':
                    $report->payment_status = 'canceled';
                    $report->payment_data = array_merge($report->payment_data ?? [], [
                        'canceled_at' => now()->toDateTimeString(),
                        'cancel_reason' => $request->input('cancelReason')
                    ]);
                    $report->save();

                    if ($returnUrl) {
                        return Redirect::to(route('car-valuation.payment-failed'))
                            ->with('error', 'Payment was canceled. Please try again.');
                    }
                    break;
                    
                default:
                    Log::warning('Unknown payment status received', [
                        'status' => $request->input('paymentStatus'),
                        'reference' => $customerRef
                    ]);
                    
                    if ($returnUrl) {
                        return Redirect::to(route('car-valuation.payment-failed'))
                            ->with('error', 'Payment status is unclear. Please contact support if the issue persists.');
                    }
            }

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            Log::error('Error processing payment webhook', [
                'error' => $e->getMessage(),
                'invoiceId' => $invoiceId
            ]);
            
            // Return 500 to trigger webhook retry
            return response()->json(['error' => 'Processing failed'], 500);
        }
    }
}
