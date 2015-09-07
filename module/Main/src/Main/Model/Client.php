<?php

namespace Main\Model;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="clients")
 **/
class Client
{
    /**
     * @Column(type="integer")
     * @Id
     * @GeneratedValue(strategy="AUTO")
     **/
    protected $id;
    
    /**
     * @Column(type="string",length=50)
     **/
    protected $name;
    
    /**
     * @Column(type="string",length=20)
     **/
    protected $vatNumber;
    
    /**
     * @OneToMany(targetEntity="Order", mappedBy="client",cascade={"persist","remove"})
     **/
    protected $orders;
    
    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }
    
    public function addOrder($order)
    {
        $this->orders[] = $order;
    }
    
    public function getOrders() {
        return $this->orders;
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getName()
    {
        return $this->name;
    }

    public function setName($in)
    {
        if (is_string($in)) {
            $this->name = $in;
        }
    }
    
    public function getVatNumber()
    {
        return $this->vatNumber;
    }

    public function setVatNumber($in)
    {
        if (is_string($in)) {
            $this->vatNumber = $in;
        }
    }
}