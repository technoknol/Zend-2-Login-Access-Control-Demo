<?php

namespace Main;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Authentication\AuthenticationService;

class Module
{
    // Must be included in one module only (it is enough)
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getServiceConfig()
    {
        return array(
            'factories'=>array(
                'MyAuthStorage' => function(){
                    return new \Main\Model\MyAuthStorage();
                },
                'MyAuthService' => function() {
                    return new AuthenticationService();
                },
            ),
        );
    }
    
    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'loginWidget' => function ($helperPluginManager) {
                    $authController = $helperPluginManager
                        ->getServiceLocator()
                        ->get('ControllerManager')
                        ->get('Main\Controller\Auth');
                    return new \Main\View\Helper\LoginWidget($authController);
                }
            )
        );
    }
    
}
