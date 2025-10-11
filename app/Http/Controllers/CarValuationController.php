<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Car;
use App\Services\CarValuationService;

class CarValuationController extends Controller
{

    public function __construct(private CarValuationService $valuationService)
    {

    }

    public function showForm()
    {
        return view('car_valuation.form');
    }

    public function submitForm(Request $request)
    {
        $validated = $request->validate([
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'mileage' => 'required|integer|min:0',
        ]);

        // $valuationService = new CarValuationService();
        $valuation = $this->valuationService->getValuation(
            $validated['make'],
            $validated['model'],
            $validated['year'],
            $validated['mileage'] ?? null
        );

        // Store valuation in session for payment step
        session([
            'valuation_data' => $validated,
            'valuation_result' => $valuation,
        ]);

        // Show message and redirect to payment
        return view('car_valuation.ready');
    }

    public function payment(Request $request)
    {
        $data = session('valuation_data');
        $valuation = session('valuation_result');
        if (!$data || !$valuation) {
            return redirect()->route('car-valuation.form');
        }
        // Prepare ABT2Pay payment link creation
        $apiKey = '9c8abc85-0fda-4218-892c-d06df8e5df72'; // Use your actual API key in an env when in production
        $callbackUrl = url('/car-valuation/result');
        $amount = 4000; // cents
        $expiresAt = now()->addWeek()->format('Y-m-d H:i');
        $customerReference = 'VAL-' . uniqid();

        $body = [
            'name' => auth()->user()->name ?? 'Customer',
            'email' => auth()->user()->email ?? 'customer@example.com',
            'phone' => auth()->user()->phone ?? '0500000000',
            'splitPayment' => false,
            'customerReferenceNumber' => $customerReference,
            'callbackUrl' => $callbackUrl,
            'amount' => $amount,
            'expiresAt' => $expiresAt,
            'products' => [
                [
                    'title' => 'Car Valuation Report',
                    'details' => $data['make'] . ' ' . $data['model'] . ' (' . $data['year'] . ')',
                    'amount' => $valuation['max'] ?? 10000,
                    'vat' => 0,
                    'quantity' => 1,
                    'total' => $valuation['max'] ?? 10000,
                ],
            ],
        ];

        $response = null;
        $paymentLink = null;
        try {
            $client = new \GuzzleHttp\Client();
            $res = $client->post('https://api.abt2pay.com/api/v1/payment/create', [
                'headers' => [
                    'X-Api-Key' => $apiKey,
                    'Accept' => 'application/json',
                ],
                'json' => $body,
            ]);
            $response = json_decode($res->getBody()->getContents(), true);

            $paymentLink = $response['paymentLink'] ?? null;
        } catch (\Exception $e) {
            return back()->withErrors(['payment' => 'Could not create payment link: ' . $e->getMessage()]);
        }

        // Show payment page with payment link
        return view('car_valuation.payment', [
            'paymentLink' => $paymentLink,
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
}
