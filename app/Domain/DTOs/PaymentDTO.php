<?php

namespace App\Domain\DTOs;

class PaymentDTO
{

    private $paymentLink;
    private $invoiceId;
    private $response;
    private $request;

    public function __construct(protected $data)
    {
        $this->paymentLink = $data['paymentLink'] ?? null;
        $this->invoiceId = $data['invoiceId'] ?? null;
        $this->response = $data['response'] ?? null;
        $this->request = $data['request'] ?? null;
    }

    /**
     * Set the value of paymentLink
     *
     * @return  self
     */
    public function setPaymentLink($paymentLink)
    {
        $this->paymentLink = $paymentLink;

        return $this;
    }
    /**
     * Get the value of paymentLink
     *
     * @return  self
     */
    public function getPaymentLink()
    {
        return $this->paymentLink;
    }

    /**
     * Set the value of invoiceId
     *
     * @return  self
     */
    public function setInvoiceId($invoiceId)
    {
        $this->invoiceId = $invoiceId;

        return $this;
    }
    /**
     * Get the value of invoiceId
     *
     * @return  self
     */
    public function getInvoiceId()
    {
        return $this->invoiceId;
    }

    /**
     * Set the value of response
     *
     * @return  self
     */
    public function setResponse($response)
    {
        $this->response = $response;

        return $this;
    }
    /**
     * Get the value of response
     *
     * @return  self
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Set the value of request
     *
     * @return  self
     */
    public function setRequest($request)
    {
        $this->request = $request;

        return $this;
    }
    /**
     * Get the value of request
     *
     * @return  self
     */
    public function getRequest()
    {
        return $this->request;
    }


}