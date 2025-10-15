<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Domain\DTOs\InvoiceDTO;
use App\Http\Requests\ValuationRequest;
use App\Models\{Car,CarValuationReport};
use App\Services\CarValuationService;
use App\Services\Payments\PaymentService;


class CarValuationController extends Controller
{

    public function __construct(private CarValuationService $valuationService,private PaymentService $paymentService)
    {

    }

    public function showForm()
    {
        return view('car_valuation.form');
    }

    public function submitForm(ValuationRequest $request)
    {
        $validated = $request->validated();

        $customerReference = 'VAL-' . uniqid();

        // Create a new empty valuation report
        $report = CarValuationReport::create([
            'user_id' => auth()->id(),
            'make' => $validated['make'],
            'model' => $validated['model'],
            'year' => $validated['year'],
            // 'min_value' => $valuation['min'],
            // 'max_value' => $valuation['max'],
            // 'average_value' => ($valuation['min'] * 0.4 + $valuation['max'] * 0.6),
            "reference" => $customerReference,
            'additional_data' => [
                // 'mileage' => $validated['mileage'],
                // 'market_demand' => $valuation['market_demand'] ?? 'moderate',
                // 'similar_listings' => $valuation['similar_listings'] ?? rand(3, 15),
                // 'days_on_market' => $valuation['days_on_market'] ?? rand(20, 45),
            ],
            'payment_status' => 'pending'
        ]);

        // Store valuation in session for payment step
        session([
            // 'valuation_data' => $validated,
            // 'valuation_result' => $valuation,
            'report_id' => $report->id
        ]);

        $apiKey = config('services.abt2pay.key');
        $callbackUrl = route('webhook.payment');
        $amount = env('UNLOCK_COST'); // cents
        $vat = 0;
        

        $invoice = new InvoiceDTO([
            'name' => auth()->user()->name ?? 'Customer',
            'email' => auth()->user()->email ?? 'customer@example.com',
            'phone' => auth()->user()->phone ?? '0500000000',
            'amount' => $amount*100,
            'customerReferenceNumber' => $customerReference,
            'products' => [
                [
                    'title' => 'Car Valuation Report',
                    'details' => $validated['make'] . ' ' . $validated['model'] . ' (' . $validated['year'] . ')',
                    'vat' => $vat,
                    'amount' => $amount,
                    'quantity' => 1,
                    'total' => $amount,
                ]
            ]
        ]);
        // public function generatePaymentLink(string $return_url, InvoiceDTO $invoice): PaymentDTO
        $response = $this->paymentService->generatePaymentLink($callbackUrl,$invoice);

        // Show payment page with payment link
        return view('car_valuation.payment', [
            'paymentLink' => $response->getPaymentLink(),
            'customerReference' => $customerReference,
        ]);
    }


    public function showResult()
    {
        $data = session('valuation_data');
        $valuation = session('valuation_result');
        if (!$data || !$valuation) {
            return redirect()->route('car-valuation.form');
        }
        return view('car_valuation.result', [
            'valuation' => $valuation,
            'data' => $data,
        ]);
    }

    public function paymentSuccess(CarValuationReport $report)
    {
        // Ensure the report belongs to the authenticated user
        if ($report->user_id !== auth()->id()) {
            abort(403);
        }
         
        // Ensure the report is actually paid
        if (!$report->isPaid()) {
            return redirect()->route('car-valuation.payment-failed')
                ->with('error', 'This report has not been paid for yet.');
        }

        return view('car_valuation.payment-success', [
            'report' => $report
        ]);
    }

    public function paymentFailed()
    {
        return view('car_valuation.payment-failed');
    }

    public function processPayment(CarValuationReport $report)
    {
        // Ensure the user can only access their own reports
        if ($report->user_id !== auth()->id()) {
            abort(403);
        }

        // Don't reprocess if already paid
        if ($report->isPaid()) {
            return redirect()->route('valuation.show', $report);
        }

        $amount = env('UNLOCK_COST');

        // Create invoice for payment
        $invoice = new InvoiceDTO([
            'name' => auth()->user()->name ?? 'Customer',
            'email' => auth()->user()->email ?? 'customer@example.com',
            'phone' => auth()->user()->phone ?? '0500000000',
            'amount' => $amount*100, 
            'customerReferenceNumber' => $report->reference,
            'products' => [
                [
                    'title' => 'Car Valuation Report',
                    'details' => $report->make . ' ' . $report->model . ' (' . $report->year . ')',
                    'vat' => 0,
                    'amount' => $amount,
                    'quantity' => 1,
                    'total' => $amount,
                ]
            ]
        ]);
        
        
        // Generate payment link
        $response = $this->paymentService->generatePaymentLink(route('webhook.payment'), $invoice);

        // Show payment page with payment link
        return view('car_valuation.payment', [
            'paymentLink' => $response->getPaymentLink(),
            'customerReference' => $report->reference,
        ]);
    }
}
