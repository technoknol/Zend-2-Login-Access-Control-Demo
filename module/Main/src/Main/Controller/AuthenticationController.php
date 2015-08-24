<?php

namespace Main\Controller;

use Zend\Mvc\Controller\AbstractActionController;

// Handles user requests to /authentication and /logout routes
//
// REM: In this application there is no /login route
//      since we use a LoginWidget.

class AuthenticationController extends AbstractActionController
{
   
    private $loginLogoutService;
    
    private function getLoginLogoutService()
    {
        if (!$this->loginLogoutService) {
            $this->loginLogoutService =
                $this->getServiceLocator()->get('LoginLogoutService');
        }
        return $this->loginLogoutService;
    }

    public function authenticateAction()
    {
        $form = $this->getLoginLogoutService()->getForm();
        $request = $this->getRequest();
        
        if ($request->isPost()){
            // Setting user entered data in the form object
            $form->setData($request->getPost());
            // Is the retrieved data valid?
            if ($form->isValid()){
                $this->getLoginLogoutService()->authenticate($request);
            }
        }

        return $this->redirect()->toRoute('home');
        
    }

    public function logoutAction()
    {
        $this->getLoginLogoutService()->logout();
        
        return $this->redirect()->toRoute('home');
    }
}