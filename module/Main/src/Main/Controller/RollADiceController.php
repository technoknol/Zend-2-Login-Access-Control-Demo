<?php

namespace Main\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Main\Service\RollADiceService;

class RollADiceController extends AbstractActionController
{
    
    private $rollADiceService;
            
    public function __construct(RollADiceService $lls)
    {
        $this->rollADiceService = $lls;
    }
    
    public function rolladiceAction()
    {
        $radView = new ViewModel();
        $radView->setTemplate('main/service/rad');
        
        $params = array();
        $params["result"] = $this->rollADiceService->getDiceResult();
        $radView->setVariables($params);
        
        return $radView;
    }
    
    public function rollADiceAjaxAction()
    {
        $diceResult = $this->rollADiceService->getDiceResult();
        $result = new JsonModel(array(
            'result' => $diceResult
        ));

        return $result;
    }
    
}
