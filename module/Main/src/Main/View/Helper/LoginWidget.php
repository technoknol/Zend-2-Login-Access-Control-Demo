<?php

namespace Main\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Main\Controller\AuthController;

// The instance of this class is created in 
// getViewHelperConfig() in Module.php

class LoginWidget extends AbstractHelper
{
    
    protected $authController;
    
    public function __construct(AuthController $authController)
    {
    	$this->authController = $authController;
    }
    
    public function __invoke()
    {
        $params = array();
        $userLoggedIn = $this->authController->getAuthService()->hasIdentity();
        $params['userLoggedIn'] = $userLoggedIn;
        
        if ( $userLoggedIn ) {
            $params['username'] = $this->authController->getAuthService()->getIdentity();
        } else {
            $params['username'] = "";
        }
        
        if ( !$userLoggedIn ) {
            $params['form'] = $this->authController->getForm();
            $params['messages'] = $this->authController->flashmessenger()->getMessages();
            $params['username'] = $this->authController->getAuthService()->getStorage()->read();
        }
        
        return $this->getView()->render('main/login/display', $params);
    }
    
}