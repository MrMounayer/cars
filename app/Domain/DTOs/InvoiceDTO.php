<?php

namespace App\Domain\DTOs;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class InvoiceDTO
{
    private $name;
    private $email;
    private $phone;
    private $amount;
    private $customer_reference_number;
    private $products;

    public function __construct(protected $data)
    {
        $this->name = $data['name'] ?? null;
        $this->email = $data['email'] ?? null;
        $this->phone = $data['phone'] ?? null;
        $this->amount = $data['amount'] ?? null;
        $this->customer_reference_number = $data['customerReferenceNumber'] ?? null;
        $this->products = $data['products'] ?? [];
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'amount' => $this->amount,
            'customerReferenceNumber' => $this->customer_reference_number,
            'products' => array_map(function ($product) {
                return $product->toArray();
            }, $this->products)
        ];
    }

    public function validate($payload, $rules)
    {
        // TODO: add validation
        try {
            Validator::validate($payload, $rules);
        } catch (ValidationException $exception) {
            throw $exception;
        }
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
    /**
     * Get the value of name
     *
     * @return  self
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }
    /**
     * Get the value of email
     *
     * @return  self
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }
    /**
     * Get the value of phone
     *
     * @return  self
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setTotalAmount($amount)
    {
        $this->amount = intval($amount);

        return $this;
    }
    /**
     * Get the value of amount
     *
     * @return  self
     */
    public function getTotalAmount()
    {
        return $this->amount;
    }

    /**
     * Set the value of customerReferenceNumber
     *
     * @return  self
     */
    public function setCustomerReferenceNumber($customer_reference_number)
    {
        $this->customer_reference_number = $customer_reference_number;

        return $this;
    }
    /**
     * Get the value of CustomerReferenceNumber
     *
     */
    public function getCustomerReferenceNumber()
    {
        return $this->customer_reference_number;
    }


    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setProduct($title, $details, $unitPrice, $vat, $quantity, $total)
    {
        $this->products[] = new InvoiceProductDTO(
            [
                "title" => $title,
                "details" => $details,
                "unitPrice" => intval($unitPrice),
                "vat" => $vat,
                "quantity" => $quantity,
                "total" => intval($total)
            ]
        );

        return $this;
    }

    public function getProducts(): array
    {
        return $this->products;
    }
}
