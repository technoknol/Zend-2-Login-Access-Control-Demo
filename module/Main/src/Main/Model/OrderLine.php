<?php

namespace Main\Model;

/**
 * @Entity @Table(name="orderlines")
 **/
class OrderLine
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;

    /** @Column(type="int") **/
    protected $orderId;
    
    /** @Column(type="string") **/
    protected $product;
    
    /** @Column(type="int") **/
    protected $quantity;
    
    /** @Column(type="float") **/
    protected $price;
    
    /** @Column(type="float") **/
    protected $vat;

    public function getId()
    {
        return $this->id;
    }

    public function getOrderId()
    {
        return $this->orderId;
    }

    public function setOrderId($in)
    {
        if (is_string($in)){
            $this->orderId = $in;
        }
    }
    
    public function getProduct()
    {
        return $this->product;
    }

    public function setProduct($in)
    {
        if (is_string($in)){
            $this->product = $in;
        }
    }
    
    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setQuantity($in)
    {
        if (is_int($in)){
            $this->quantity = $in;
        }
    }
    
    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($in)
    {
        if (is_float($in)){
            $this->price = $in;
        }
    }

    public function getVat()
    {
        return $this->vat;
    }

    public function setVat($in)
    {
        if (is_float($in)){
            $this->vat = $in;
        }
    }
}
