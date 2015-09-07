<?php

namespace Main\Model;

/**
 * @Entity
 * @Table(name="orderlines")
 **/
class OrderLine
{
    /**
     * @Column(type="integer")
     * @Id
     * @GeneratedValue(strategy="AUTO")
     **/
    protected $id;

    /**
     * @ManyToOne(targetEntity="Order", inversedBy="orderslines")
     */
    protected $order;
    
    /**
     * @Column(type="string",length=50)
     **/
    protected $product;
    
    /**
     * @Column(type="integer")
     **/
    protected $quantity;
    
    /**
     * @Column(type="decimal", scale=2)
     **/
    protected $price;
    
    /**
     * @Column(type="decimal", scale=2)
     **/
    protected $vat;

    public function getId()
    {
        return $this->id;
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function setOrder($in)
    {
        if ( $in ) {
            $in->addOrderLine($this);
            $this->order = $in;
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
