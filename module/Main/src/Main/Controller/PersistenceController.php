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
    }
    
    public function clientsAction()
    {
        $vm = new ViewModel();
        $vm->setVariable("clients",
            $this->persistenceService->getClients());
        return $vm;
    }
    
    public function clientAction()
    {
        $id = (int) $this->params()->fromRoute('id', -1);
        $vm = new ViewModel();
        $vm->setVariable("client",
            $this->persistenceService->getClient($id));
        return $vm;
    }
    
    public function orderAction()
    {
        $id = (int) $this->params()->fromRoute('id', -1);
        $vm = new ViewModel();
        $vm->setVariable("order",
            $this->persistenceService->getOrder($id));
        return $vm;
    }
    
    public function createClientAction()
    {
        $nc = $this->persistenceService->newDummyClient();
        // Persist $nc
        return $this->redirect()->toRoute('clients');
    }
    
    public function deleteClientAction()
    {
        $id = (int) $this->params()->fromRoute('id', -1);
        $this->persistenceService->deleteClient($id);
        return $this->redirect()->toRoute('clients');
    }
    
    public function createOrderAction()
    {
        $cid = (int) $this->params()->fromRoute('clientid', -1);
        $no = $this->persistenceService->newDummyOrder($cid);
        // Persist $no
        return $this->redirect()->toRoute('clients');
    }
    
    public function deleteOrderAction()
    {
        $id = (int) $this->params()->fromRoute('id', -1);
        $this->persistenceService->deleteOrder($id);
        return $this->redirect()->toRoute('clients');
    }
    
    public function createOrderLineAction()
    {
        $oid = (int) $this->params()->fromRoute('orderid', -1);
        $nol = $this->persistenceService->newDummyOrderLine($oid);
        // Persist $nol
        return $this->redirect()->toRoute('clients');
    }
    
    public function deleteOrderLineAction()
    {
        $id = (int) $this->params()->fromRoute('id', -1);
        $this->persistenceService->deleteOrder($id);
        return $this->redirect()->toRoute('clients');
    }
    
    public function resetWithDemoDataAction() {
        $this->persistenceService->resetWithDemoData();
        return $this->redirect()->toRoute('clients');
    }
}
