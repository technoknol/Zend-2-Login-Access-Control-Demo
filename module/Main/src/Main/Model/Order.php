<?php

namespace Main\Model;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity @Table(name="orders")
 **/
class Order
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;
    
    /**
     * @Column(type="integer")
     * @ManyToOne(targetEntity="client",inversedBy="orders",cascade={"persist"})
     * @JoinColumn(name="clientId",referencedColumnName="id")
     */
    protected $clientId;

    /**
     * @OneToMany(targetEntity="OrderLine", mappedBy="orderId",cascade={"persist"})
     * @var OrderLine[]
     */
    protected $orderLines;
    
    public function __construct()
    {
        $this->orderLines = new ArrayCollection();
    }
    
    public function addOrderLine($orderline)
    {
        $this->orderLines[] = $orderline;
    }
    
    public function getOrderLines() {
        return $this->orderlines;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getClientId()
    {
        return $this->clientId;
    }

    public function setClientId($in)
    {
        if (is_int($in)){
            $this->clientId = $in;
        }
    }
}
