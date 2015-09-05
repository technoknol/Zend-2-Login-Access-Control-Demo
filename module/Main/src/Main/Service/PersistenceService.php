<?php

namespace Main\Service;

use Main\Database\DemoDatabase;
use Main\Model\Client;
use Main\Model\Order;
use Main\Model\OrderLine;

class PersistenceService
{
    
    private static $clientNames = array("Anna","Pedro","Ryan","Alfredo","John",
        "Ming","Eleonora","Fritz","Johanna","Eric","Peter","Mike","Sven","Rudy"); 
    
    private static $productNames = array("Ball","Table","Fruit","Chair","Car",
        "Fork","Knife","Painting","Shoes","Trouser","Skirt","Socks","Pen"); 
    
    private static $vatPercentages = array(0.05,0.09,0.10,0.15,0.20,0.21,0.23); 
    
    private $dbLocation;
    private $db;
    
    public function __construct()
    {
        $this->dbLocation = __DIR__ . "/../Database/demo.db";
        $this->db = new DemoDatabase($this->dbLocation);
    }
    
    private function checkSchema() {
        
    }
    
    public function getClient($clientId) {
        if (is_int($clientId)){
            
        }
    }
    
    public function deleteClient($clientId) {
        if (is_int($clientId)){
            
        }
    }
    
    public function getOrder($orderId) {
        if (is_int($orderId)){
            
        }
    }
    
    public function deleteOrder($orderId) {
        if (is_int($orderId)){
            
        }
    }
    
    public function resetWithDemoDataAction() {
        $this->checkSchema();
        // Delete all clients, cascade
        // Delete all orders, cascade
        // Delete all order lines, cascade
        for ($i=0;$i<3;$i++) {
            $tmpClient = $this->newDummyClient();
            // Persist tmpClient
            for ($j=1;$j<rand(1,7);$j++) {
                $tmpOrder = $this->newDummyOrder($tmpClient->getId());
                // Persist tmpOrder
                for ($k=1;$k<rand(3,13);$k++) {
                    $tmpOrderLine = $this->newDummyOrderLine($tmpOrder->getId());
                    // Persist tmpOrderLine
                }
                // Flush order lines?
            }
        }
        
    }
    
    public function newDummyClient() {
        $res = new Client();
        $tmp = rand (0,sizeof(PersistenceService::$clientNames));
        $dummyName = PersistenceService::$clientNames[$tmp];
        $dummyName = $dummyName.rand(10,100);
        $res->setName($dummyName);
        $tmp = "VAT-".rand(1000,30000);
        $res->setVatNumber($tmp);
        return $res;
    }

    public function newDummyOrder($clientId) {
        $res = new Order();
        $res->setClientId($clientId);
        $res->setCreationDate(new \DateTime());
        return $res;
    }
    
    public function newDummyOrderLine($orderId) {
        $res = new OrderLine();
        $res->setOrderId($orderId);
        $tmp1 = rand(0,sizeof(PersistenceService::$productNames));
        $res->setProduct(PersistenceService::$productNames[$tmp1]);
        $res->setPrice((rand(1,20000)/100));
        $res->setQuantity(rand(1,20));
        $tmp2 = rand (0,sizeof(PersistenceService::$vatPercentages));
        $res->setVat(PersistenceService::$vatPercentages[$tmp2]);
        return $res;
    }
}
