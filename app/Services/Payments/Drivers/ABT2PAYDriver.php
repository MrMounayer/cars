<?php

namespace App\Services\Payments\Drivers;

// use App\Enums\IntegrationStatus;
use App\Services\Payments\Drivers\Interfaces\PaymentGatewayDriverInterface;
use App\Domain\DTOs\InvoiceDTO;
use App\Domain\DTOs\InvoiceProductDTO;
use App\Domain\DTOs\PaymentDTO;
use App\Domain\DTOs\PaymentStatusDTO;
use App\Services\Payments\Exceptions\ABT2PAYDriverError;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ABT2PAYDriver implements PaymentGatewayDriverInterface
{
    public function __construct(protected array $config)
    {
        $this->config["token"] = config('services.abt2pay.key');
        $this->config["base"] = config('services.abt2pay.url', 'https://api.abt2pay.com/api/v1/');
    }

    public function generatePaymentLink(string $return_url, InvoiceDTO $invoice): PaymentDTO
    {
        $data = [
            'name' => $invoice->getName(),
            'email' => $invoice->getEmail(),
            'phone' => $invoice->getPhone(),
            'recur'=> false,
            'splitPayment' => false,
            'customerReferenceNumber' => $invoice->getCustomerReferenceNumber(), 
            'test' => true,
            "callbackUrl" => $return_url,
            'amount' => $invoice->getTotalAmount(),
            'products' => $invoice->getProducts()
        ];

        $response = Http::withHeaders([
            'X-Api-Key' => config('services.abt2pay.key'),
        ])->post(config('services.abt2pay.url')."payment/create", $data);

        // dd( $response->json());
        
        throw_if(
            $response->json('status') == "failed" && !$response->json("alreadyExists"),
            new ABT2PAYDriverError('ABT2PAY payment gateway failed: '. $response->json('message'))
        );

        return new PaymentDTO([
                "paymentLink" => $response->json('paymentLink'),
                "invoiceId" => $response->json('invoiceId'),
                "response" => $response->json(),
                "request" => $data
            ]);
    }

    public function paymentCallback(Request $request): PaymentStatusDTO
    {
        $invoice_id = $request->get("invoiceId");

        if(is_null($invoice_id)) return false;
        $response = Http::withHeaders([
            'X-Api-Key' => $this->config['token'],
            ])->get(config('services.abt2pay.url')."payment/status", ["invoiceId" => $invoice_id]);
            
       
            $status = $response->json('status') === "success" && $response->json('paymentStatus') === "completed";

        return new PaymentStatusDTO([
            "status" => $status,
            "response" => $response->json(),
            "request" => ["invoice_id" => $invoice_id]
        ]);
    }

    public function paymentCancel(string $cancelledInvoiceId): PaymentStatusDTO
    {
        $invoice_id = $cancelledInvoiceId ?? null;

        if(is_null($invoice_id))
            throw new ABT2PAYDriverError('Invoice ID not found');

        $response = Http::withHeaders([
            'X-Api-Key' => $this->config['token'],
        ])->get(config('services.abt2pay.url')."payment/cancel", ["invoiceId" => $invoice_id]);

        $status = $response->json('status') === "success"
            && $response->json('paymentStatus') === "canceled";

        return new PaymentStatusDTO([
            "status" => $status,
            "response" => $response->json(),
            "request" => ["invoice_id" => $invoice_id]
        ]);
    }

    // public function getStatus(array $request, array $response): IntegrationStatus
    // {
    //     return match ($response['status'] ?? null) {
    //         "success" => IntegrationStatus::Success, //TODO: Confirm with ABT2PAY
    //         default => IntegrationStatus::Error,
    //     };
    // }
}
