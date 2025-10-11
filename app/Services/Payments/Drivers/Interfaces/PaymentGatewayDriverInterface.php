<?php

namespace App\Services\Payments\Drivers\Interfaces;

use App\Domain\DTOs\InvoiceDTO;
use App\Domain\DTOs\PaymentDTO;
use App\Domain\DTOs\PaymentStatusDTO;
use Illuminate\Http\Request;

interface PaymentGatewayDriverInterface
{
    public function generatePaymentLink(string $return_url, InvoiceDTO $invoice):PaymentDTO;

    public function paymentCallback(Request $request): PaymentStatusDTO;
    
    public function paymentCancel(string $cancelledInvoiceId): PaymentStatusDTO;
}
