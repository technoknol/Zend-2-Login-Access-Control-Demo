<?php
// Filename: /module/Template/src/Template/Controller/MyController.php
namespace Template\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class MyyController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }
}