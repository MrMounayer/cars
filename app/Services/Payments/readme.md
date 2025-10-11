# Payments Gateway service

1. Initialize payment gateway service

```php 
$driver = "payd";
$config = [
    'token' => '...'
];

$paymentGateway = PaymentService::for($driver, $config);
```

2. Generate a payment link

```php
$return_url = '...';
$paymentLink = $paymentGateway->generatePaymentLink($return_url);
return redirect()->to($paymentLink);
```

3. Process the callback
```php
$paymentResponse = $paymentGateway->paymentCallback($request);
```
