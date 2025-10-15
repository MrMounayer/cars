<?php

namespace App\Services\Payments;


use App\Enums\IntegrationStatus;
use App\Services\Payments\Drivers\Interfaces\PaymentGatewayDriverInterface;
use App\Domain\DTOs\InvoiceDTO;
use App\Domain\DTOs\PaymentDTO;
use App\Domain\DTOs\PaymentStatusDTO;
use App\Services\Payments\Exceptions\PaymentGatewayDriverNotSupported;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentService implements PaymentGatewayDriverInterface
{
    protected $paymentGateway;
    public function __construct(protected string $driver="ABT2PAY", protected array $config = [])
    {
        $class = 'App\Services\Payments\Drivers\\' . Str::studly($this->driver) . 'Driver';

        throw_unless(
            class_exists($class),
            new PaymentGatewayDriverNotSupported(Str::studly($this->driver). ' payment gateway driver not supported')
        );

        $this->paymentGateway = new $class($this->config);
    }

    public static function for(string $driver, array $config = []): PaymentService
    {
        return new static($driver, $config);
    }

    public function generatePaymentLink(string $return_url, InvoiceDTO $invoice): PaymentDTO
    {
        return $this->paymentGateway->generatePaymentLink($return_url, $invoice);
    }

    public function paymentCallback(Request $request): PaymentStatusDTO
    {
        return $this->paymentGateway->paymentCallback($request);
    }

    public function paymentCancel(string $cancelledInvoiceId): PaymentStatusDTO
    {
        return $this->paymentGateway->paymentCancel($cancelledInvoiceId);
    }

    public function getStatus(array $request, array $response): IntegrationStatus
    {
        return $this->paymentGateway->getStatus($request, $response);
    }
}
