<?php

namespace App\Domain\DTOs;

class InvoiceProductDTO
{
    private $title;
    private $details;
    private $unitPrice;
    private $vat;
    private $quantity;
    private $total;

    public function __construct(protected $data)
    {
        $this->title = $data['title'] ?? "";
        $this->details = $data['details'] ?? "";
        $this->unitPrice = $data['unitPrice'] ?? 0;
        $this->vat = $data['vat'] ?? 0;
        $this->quantity = $data['quantity'] ?? 1;
        $this->total = $data['total'] ?? 0;
    }

    public function toArray(): array
    {
        return [
            "title" => $this->title,
            "details" => $this->details,
            "unitPrice" => $this->unitPrice,
            "vat" => $this->vat,
            "quantity" => $this->quantity,
            "total" => $this->total
        ];
    }

    /**
     * Set the value of title
     *
     * @return  self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }
    /**
     * Get the value of title
     *
     * @return  self
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of details
     *
     * @return  self
     */
    public function setDetails($details)
    {
        $this->details = $details;

        return $this;
    }
    /**
     * get the value of details
     *
     * @return  self
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * Set the value of unitPrice
     *
     * @return  self
     */
    public function setUnitPrice($unitPrice)
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }
    /**
     * get the value of unitPrice
     *
     * @return  self
     */
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }

    /**
     * Set the value of vat
     *
     * @return  self
     */
    public function setVAT($vat)
    {
        $this->vat = $vat;

        return $this;
    }
    /**
     * get the value of vat
     *
     * @return  self
     */
    public function getVATValue()
    {
        return $this->vat;
    }

    /**
     * Set the value of quantity
     *
     * @return  self
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }
    /**
     * get the value of quantity
     *
     * @return  self
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set the value of total
     *
     * @return  self
     */
    public function setTotalAmount($total)
    {
        $this->total = $total;

        return $this;
    }
    /**
     * get the value of total
     *
     * @return  self
     */
    public function getTotalAmount()
    {
        return $this->total;
    }
}
