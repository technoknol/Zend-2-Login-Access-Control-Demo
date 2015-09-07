<?php

namespace Main\Model;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="orders")
 **/
class Order
{
    /**
     * @Column(type="integer")
     * @Id
     * @GeneratedValue(strategy="AUTO")
     **/
    protected $id;
    
    /**
     * @ManyToOne(targetEntity="Client", inversedBy="orders")
     */
    protected $client;

    /**
     * @OneToMany(targetEntity="OrderLine", mappedBy="order",cascade={"persist","remove"})
     */
    protected $orderlines;
    
    public function __construct()
    {
        $this->orderlines = new ArrayCollection();
    }
    
    public function addOrderLine($orderline)
    {
        $this->orderlines[] = $orderline;
    }
    
    public function getOrderLines() {
        return $this->orderlines;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function setClient($in)
    {
        if ( $in ) {
            $in->addOrder($this);
            $this->client = $in;
        }
    }
}
