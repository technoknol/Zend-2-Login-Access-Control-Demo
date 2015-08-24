<?php

namespace Main\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AccessController extends AbstractActionController
{
    public function userAction()
    {
        return new ViewModel();
    }
    
    public function adminAction()
    {
        return new ViewModel();
    }
}
