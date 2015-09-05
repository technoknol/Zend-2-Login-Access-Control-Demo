<?php

namespace Main\Model;

/**
 * @Entity @Table(name="clients")
 **/
class Client
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;
    
    /** @Column(type="string") **/
    protected $name;
    
    /** @Column(type="string") **/
    protected $vatNumber;
    
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