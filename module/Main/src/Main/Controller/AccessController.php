<?php

namespace Main\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Permissions\Rbac\Rbac;
use Zend\Permissions\Rbac\Role;
use Zend\Mvc\Controller\PluginManager;
use Main\Controller\AccessController;
use Main\Service\AuthenticationAdaptor;

class AccessController extends AbstractActionController
{
    const ROLE_AUTHENTICATED = "authenticated"; 
    const ROLE_ADMINISTRATOR = "admin"; 
    
    const PERM_USER_DATA = "userData"; 
    
    private $loginLogoutService;
    
    private $rbac;
    private $accDen403View;
    
    public function __construct()
    {
        $this->accDen403View = new ViewModel();
        $this->accDen403View->setTemplate('error/403');
        
        $this->rbac = new Rbac();
        
        $authenticated  = new Role(AccessController::ROLE_AUTHENTICATED);
        $authenticated->addPermission(AccessController::PERM_USER_DATA);
        $this->rbac->addRole($authenticated);
        
        $admin  = new Role(AccessController::ROLE_ADMINISTRATOR);
        $this->rbac->addRole($admin);
    }
    
    public function setPluginManager(PluginManager $plugins) {
        parent::setPluginManager($plugins);
        $this->loginLogoutService = $this->getServiceLocator()
            ->get('LoginLogoutService');
    }
    
    public function isValidRole($role) {
        
        return ( $role === AccessController::ROLE_AUTHENTICATED )
            || ( $role === AccessController::ROLE_ADMINISTRATOR );
        
    }
    
    public function loggedInUserHasRole($role) {
        
        if ( !$this->isValidRole($role) ) {
            return false;
        }
        
        $li = $this->loginLogoutService->getLoggedIdentity();
        
        if ( !is_array($li) ) {
            return false;
        }
        
        $gr = $li[AuthenticationAdaptor::GRANTED_ROLES];
        
        if ( !is_array($gr) ) {
            return false;
        }
        
        return in_array($role,$gr);
    }
    
    public function getLoggedInName() {
        $li = $this->loginLogoutService->getLoggedIdentity();
        if ( !is_array($li) ) {
            return null;
        } else {
            return $li[AuthenticationAdaptor::USERNAME];
        }
    }
    
    public function userAction()
    {
        $usrname = (string) $this->params()->fromRoute('username', "");
        $vm = new ViewModel();
        $vm->setVariable("currentUser", $usrname);
        
        if ( $this->loggedInUserHasRole(AccessController::ROLE_ADMINISTRATOR) ) {
            return $vm;
        } else if ( $this->loggedInUserHasRole(AccessController::ROLE_AUTHENTICATED) ) {
            if ( $usrname === $this->getLoggedInName()) {
                return $vm;
            }
        }
        return $this->accDen403View;
    }
    
    public function adminAction()
    {
        if ( $this->loggedInUserHasRole(AccessController::ROLE_ADMINISTRATOR)) {
            new ViewModel();
        } else {
            return $this->accDen403View;
        }
    }
    
}
