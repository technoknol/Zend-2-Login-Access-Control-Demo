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
        $res = array();
        $clnt = $this->clientRepository->find($clientId);
        if ( $clnt ) {
            $res = $clnt->getOrders();
        }
        return $res;
    }
    
    public function getOrderLines($orderId) {
        $res = array();
        $clnt = $this->orderRepository->find($orderId);
        if ( $clnt ) {
            $res = $clnt->getOrderLines();
        }
        return $res;
    }
    
    public function getClient($clientId) {
        $res = null;
        if (is_int($clientId)){
            $res = $this->clientRepository->find($clientId);
        }
        return $res;
    }
    
    public function deleteClient($clientId) {
        if (is_int($clientId)) {
            $res = $this->clientRepository->find($clientId);
            $this->getEM()->remove($res);
            $this->getEM()->flush();
        }
    }
    
    public function getOrder($orderId) {
        $res = null;
        if (is_int($orderId)){
            $res = $this->orderRepository->find($orderId);
        }
        return $res;
    }
    
    public function deleteOrder($orderId) {
        if (is_int($orderId)) {
            $res = $this->orderRepository->find($orderId);
            $this->getEM()->remove($res);
            $this->getEM()->flush();
        }
    }
    
    public function getOrderLine($orderLineId) {
        $res = null;
        if (is_int($orderLineId)){
            $res = $this->orderLinesRepository->find($orderLineId);
        }
        return $res;
    }

    public function deleteOrderLine($orderLineId) {
        if (is_int($orderLineId)) {
            $res = $this->orderLinesRepository->find($orderLineId);
            $this->getEM()->remove($res);
            $this->getEM()->flush();
        }
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
                $tmpOrder = $this->newDummyOrder($tmpClient);
                $tmpClient->addOrder($tmpOrder);
            }
            $this->db->getEntityManager()->persist($tmpClient);
            $this->db->getEntityManager()->flush();
            
            $tmpOrders = $tmpClient->getOrders();
            foreach ($tmpOrders as $tmpOrderr) {
                for ($k=1;$k<=rand(3,13);$k++) {
                    $tmpOrderLine = $this->newDummyOrderLine($tmpOrderr);
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

    public function newDummyOrder($client) {
        $res = new Order();
        $res->setClient($client);
        return $res;
    }
    
    public function newDummyOrderLine($order) {
        $res = new OrderLine();
        $res->setOrder($order);
        $tmp1 = rand(0,(sizeof(PersistenceService::$productNames)-1));
        $res->setProduct(PersistenceService::$productNames[$tmp1]);
        $price = rand(1,20000) / 100.0;
        $res->setPrice($price);
        $res->setQuantity(rand(1,20));
        $tmp2 = rand (0,(sizeof(PersistenceService::$vatPercentages)-1));
        $res->setVat(PersistenceService::$vatPercentages[$tmp2]);
        return $res;
    }
    
    public function getEM() {
        return $this->db->getEntityManager();
    }
}
