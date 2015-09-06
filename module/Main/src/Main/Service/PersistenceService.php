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
    
    private $clientRepository;
    private $orderRepository;
    private $orderLinesRepository;
    
    public function __construct()
    {
        // Creating/Accessing database
        $this->dbLocation = __DIR__ . "/../Database/demo.db";
        $this->db = new DemoDatabase($this->dbLocation);
        
        // Initalizing repositories
        $this->clientRepository =$this->db->getEntityManager()
            ->getRepository('\Main\Model\Client');
        
        $this->orderRepository = $this->db->getEntityManager()
            ->getRepository('\Main\Model\Order');
        
        $this->orderLinesRepository = $this->db->getEntityManager()
            ->getRepository('\Main\Model\OrderLine');
    }
    
    private function checkSchema() {
        $this->db->checkTableCreation();
    }

    public function getClients() {
        return $this->clientRepository->findAll();
    }
    
    public function getOrders($clientId) {
        return $this->db->getEntityManager()
            ->getRepository('\Main\Model\Order')->findBy(
            array('clientId' => $clientId));
    }
    
    public function getOrderLines($orderId) {
        return $this->orderLinesRepository->findBy(
            array('orderId' => $orderId));
    }
    
    public function getClient($clientId) {
        $res = null;
        if (is_int($clientId)){
            $res = $this->db->getEntityManager()
                ->find('\Main\Model\Client',$clientId);
        }
        return $res;
    }
    
    public function deleteClient($clientId) {
        $res = null;
        if (is_int($clientId)) {
            $retr = $this->getClient($clientId);
            if ( $retr ) {
                $this->db->getEntityManager()->remove($retr);
                $this->db->getEntityManager()->flush();
            }
        }
        return $res;
    }
    
    public function getOrder($orderId) {
        $res = null;
        if (is_int($orderId)){
            $res = $this->db->getEntityManager()
                ->find('\Main\Model\Order',$orderId);
        }
        return $res;
    }
    
    public function deleteOrder($orderId) {
        $res = null;
        if (is_int($orderId)){
            $retr = $this->getOrder($orderId);
            if ( $retr ) {
                $this->db->getEntityManager()->remove($retr);
                $this->db->getEntityManager()->flush();
            }
        }
        return $res;
    }
    
    public function getOrderLine($orderLineId) {
        $res = null;
        if (is_int($orderLineId)){
            $res = $this->db->getEntityManager()
                ->find('\Main\Model\OrderLine',$orderLineId);
        }
        return $res;
    }

    public function deleteOrderLine($orderLineId) {
        $res = null;
        if (is_int($orderLineId)){
            $retr = $this->getOrderLine($orderLineId);
            if ( $retr ) {
                $this->db->getEntityManager()->remove($retr);
                $this->db->getEntityManager()->flush();
            }
        }
        return $res;
    }
    
    public function resetWithDemoData() {
        $this->checkSchema();
        
        $q1 = $this->db->getEntityManager()->createQuery(
            'delete from Main\Model\OrderLine');
        $q1->execute();
        
        $q2 = $this->db->getEntityManager()->createQuery(
            'delete from Main\Model\Order');
        $q2->execute();
        
        $q3 = $this->db->getEntityManager()->createQuery(
            'delete from Main\Model\Client');
        $q3->execute();
        
        for ($i=0;$i<4;$i++) {
            
            $tmpClient = $this->newDummyClient();
            $this->db->getEntityManager()->persist($tmpClient);
            $this->db->getEntityManager()->flush();
            
            for ($j=1;$j<=rand(1,7);$j++) {
                $tmpOrder = $this->newDummyOrder($tmpClient->getId());
                $tmpClient->addOrder($tmpOrder);
            }
            $this->db->getEntityManager()->persist($tmpClient);
            $this->db->getEntityManager()->flush();
            
            $tmpOrders = $tmpClient->getOrders();
            foreach ($tmpOrders as $tmpOrderr) {
                for ($k=1;$k<=rand(3,13);$k++) {
                    $tmpOrderLine = $this->newDummyOrderLine($tmpOrderr->getId());
                    $tmpOrderr->addOrderLine($tmpOrderLine);
                }
                $this->db->getEntityManager()->persist($tmpOrderr);
                $this->db->getEntityManager()->flush();
            }
        }
    }
    
    public function newDummyClient() {
        $res = new Client();
        $tmp = rand (0,(sizeof(PersistenceService::$clientNames)-1));
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
        return $res;
    }
    
    public function newDummyOrderLine($orderId) {
        $res = new OrderLine();
        $res->setOrderId($orderId);
        $tmp1 = rand(0,(sizeof(PersistenceService::$productNames)-1));
        $res->setProduct(PersistenceService::$productNames[$tmp1]);
        $price = rand(1,20000) / 100.0;
        $res->setPrice($price);
        $res->setQuantity(rand(1,20));
        $tmp2 = rand (0,(sizeof(PersistenceService::$vatPercentages)-1));
        $res->setVat(PersistenceService::$vatPercentages[$tmp2]);
        return $res;
    }
}
