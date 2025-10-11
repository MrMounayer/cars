<?php

namespace App\Domain\DTOs;

class PaymentStatusDTO
{

    private $status;
    private $response;
    private $request;

    public function __construct(protected $data)
    {
        $this->status = $data['status'] ?? null;
        $this->response = $data['response'] ?? null;
        $this->request = $data['request'] ?? null;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }
    /**
     * Get the value of status
     *
     * @return  self
     */
    public function getStatus()
    {
        return $this->status;
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