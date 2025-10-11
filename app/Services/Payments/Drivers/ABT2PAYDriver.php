<?php

namespace App\Services\Payments\Drivers;

use App\Enums\IntegrationStatus;
use App\Services\Payments\Drivers\Interfaces\PaymentGatewayDriverInterface;
use App\Domain\DTOs\InvoiceDTO;
use App\Domain\DTOs\InvoiceProductDTO;
use App\Domain\DTOs\PaymentDTO;
use App\Domain\DTOs\PaymentStatusDTO;
use App\Services\Payments\Exceptions\PaydDriverError;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ABT2PAYDriver implements PaymentGatewayDriverInterface
{
    public function __construct(protected array $config)
    {
    }

    public function generatePaymentLink(string $return_url, InvoiceDTO $invoice): PaymentDTO
    {
        $data = [
            'name' => $invoice->getName(),
            'email' => $invoice->getEmail(),
            'phone' => $invoice->getPhone(),
            'splitPayment' => false,
            'customerReferenceNumber' => $invoice->getCustomerReferenceNumber(), //TODO: Implement it with Samir  add quote uid + random 
            'test' => false,
            "callbackUrl" => $return_url,
            'amount' => $invoice->getTotalAmount(),
            'products' => array_map(function (InvoiceProductDTO $product) {
                return [
                    'title' => $product->getTitle(),
                    'details' => $product->getDetails(),
                    'amount' => $product->getUnitPrice(),
                    'vat' => $product->getVATValue(),
                    'quantity' => $product->getQuantity(),
                    'total' => $product->getTotalAmount(),
                ];
            }, $invoice->getProducts())
        ];

        $response = Http::withHeaders([
            'X-Api-Key' => $this->config['token'],
        ])->post(config('services.payd.base')."payment/create", $data);

        throw_if(
            $response->json('status') == "failed" && !$response->json("alreadyExists"),
            new PaydDriverError('Payd payment gateway failed: '. $response->json('message'))
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
        ])->get(config('services.payd.base')."payment/status", ["invoiceId" => $invoice_id]);

        $status = $response->json('status') === "success"
            && $response->json('paymentStatus') === "completed";

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
            throw new PaydDriverError('Invoice ID not found');

        $response = Http::withHeaders([
            'X-Api-Key' => $this->config['token'],
        ])->get(config('services.payd.base')."payment/cancel", ["invoiceId" => $invoice_id]);

        $status = $response->json('status') === "success"
            && $response->json('paymentStatus') === "canceled";

        return new PaymentStatusDTO([
            "status" => $status,
            "response" => $response->json(),
            "request" => ["invoice_id" => $invoice_id]
        ]);
    }

    public function getStatus(array $request, array $response): IntegrationStatus
    {
        return match ($response['status'] ?? null) {
            "success" => IntegrationStatus::Success, //TODO: Confirm with Payd
            default => IntegrationStatus::Error,
        };
    }
}
