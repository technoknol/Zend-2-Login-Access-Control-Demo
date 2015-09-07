<?php

namespace Main\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class PersistenceController extends AbstractActionController
{
    
    private $persistenceService;
    
    public function __construct($ps)
    {
        $this->persistenceService = $ps;
        
        session_start();
        if (!isset($_SESSION["lastUrl"])) {
            $_SESSION["lastUrl"] = "/";
        }
    }
    
    public function clientsAction()
    {
        $_SESSION["lastUrl"] = "/clients";
        $vm = new ViewModel();
        $vm->setVariable("clients",
            $this->persistenceService->getClients());
        return $vm;
    }
    
    public function clientAction()
    {
        $id = (int) $this->params()->fromRoute('id', -1);
        if ( $id >= 0 ) {
            $_SESSION["lastUrl"] = "/client/".$id;
        }
        $vm = new ViewModel();
        $vm->setVariable("client",
            $this->persistenceService->getClient($id));
        $vm->setVariable("orders",
            $this->persistenceService->getOrders($id));
        return $vm;
    }
    
    public function orderAction()
    {
        $id = (int) $this->params()->fromRoute('id', -1);
        if ( $id > 0 ) {
            $_SESSION["lastUrl"] = "/order/".$id;
        }
        $vm = new ViewModel();
        $vm->setVariable("order",
            $this->persistenceService->getOrder($id));
        $vm->setVariable("orderLines",
            $this->persistenceService->getOrderLines($id));
        return $vm;
    }
    
    public function createClientAction()
    {
        $nc = $this->persistenceService->newDummyClient();
        $this->persistenceService->getEM()->persist($nc);
        $this->persistenceService->getEM()->flush();
        return $this->redirect()->toRoute('clients');
    }
    
    public function deleteClientAction()
    {
        $id = (int) $this->params()->fromRoute('id', -1);
        if ( $id >= 0 ) {
            $this->persistenceService->deleteClient($id);
        }
        return $this->redirect()->toRoute('clients');
    }
    
    public function createOrderAction()
    {
        $cid = (int) $this->params()->fromRoute('clientid', -1);
        if ( $cid >= 0 ) {
            $client = $this->persistenceService->getClient($cid);
            $no = $this->persistenceService->newDummyOrder($client);
            $this->persistenceService->getEM()->persist($no);
            $this->persistenceService->getEM()->flush();
        }
        return $this->redirect()->toUrl($_SESSION["lastUrl"]);
    }
    
    public function deleteOrderAction()
    {
        $id = (int) $this->params()->fromRoute('id', -1);
        if ( $id >= 0 ) {
            $this->persistenceService->deleteOrder($id);
        }
        return $this->redirect()->toUrl($_SESSION["lastUrl"]);
    }
    
    public function createOrderLineAction()
    {
        $oid = (int) $this->params()->fromRoute('orderid', -1);
        if ( $oid >= 0 ) {
            $client = $this->persistenceService->getOrder($oid);
            $nol = $this->persistenceService->newDummyOrderLine($client);
            $this->persistenceService->getEM()->persist($nol);
            $this->persistenceService->getEM()->flush();
        }
        return $this->redirect()->toUrl($_SESSION["lastUrl"]);
    }
    
    public function deleteOrderLineAction()
    {
        $id = (int) $this->params()->fromRoute('id', -1);
        if ( $id >= 0 ) {
            $this->persistenceService->deleteOrderLine($id);
        }
        return $this->redirect()->toUrl($_SESSION["lastUrl"]);
    }
                    
    public function resetWithDemoDataAction() {
        $this->persistenceService->resetWithDemoData();
        return $this->redirect()->toRoute('clients');
    }
}
