<?php

namespace Main;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Main\View\Helper\LoginWidget;
use Main\Service\LoginLogoutService;
use Main\Service\RollADiceService;
use Main\Controller\AuthenticationController;
use Main\Controller\RollADiceController;

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
                'RollADiceService' => function() {
                    return new RollADiceService();
                },
            ),
        );
    }
    
    public function getControllerConfig() {
        return array(
            'factories' => array(
                'Main\Controller\Authentication' => function($cm) {
                    $sm   = $cm->getServiceLocator();
                    $depA = $sm->get('LoginLogoutService');
                    $controller = new AuthenticationController($depA);
                    return $controller;
                },
                'Main\Controller\RollADice' => function($cm) {
                    $sm   = $cm->getServiceLocator();
                    $depA = $sm->get('RollADiceService');
                    $controller = new RollADiceController($depA);
                    return $controller;
                }
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
                    return new LoginWidget($loginOutSrv);
                }
            )
        );
    }
    
}
