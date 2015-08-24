<?php

namespace Main;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Main\Service\LoginLogoutService;

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
                'LoginLogoutService' => function() {
                    return new LoginLogoutService();
                },
            ),
        );
    }
    
    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'loginWidget' => function ($helperPluginManager) {
                    $loginOutSrv = $helperPluginManager
                        ->getServiceLocator()
                        ->get('LoginLogoutService');
                    return new \Main\View\Helper\LoginWidget($loginOutSrv);
                }
            )
        );
    }
    
}
