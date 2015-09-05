<?php

namespace Main\Model;

/**
 * @Entity @Table(name="orders")
 **/
class Order
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;
    
    /** @Column(type="int") **/
    protected $clientId;
    /**
     * @Column(type="datetime")
     * @var DateTime
     */
    protected $creationDate;
    
    protected $lines;
    
    public function __construct()
    {
        $this->lines = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getClientId()
    {
        return $this->deliveryAddressId;
    }

    public function setClientId($in)
    {
        if (is_int($in)){
            $this->deliveryAddressId = $in;
        }
    }
    
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    public function setCreationDate($in)
    {
        if (is_date($in)){
            $this->creationDate = $in;
        }
    }
}
