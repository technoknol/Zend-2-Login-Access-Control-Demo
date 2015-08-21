<?php

// Filename: /module/Main/Module.php
 namespace Template;
 
 use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
 use Zend\ModuleManager\Feature\ConfigProviderInterface;

 // The class MUST be named module
 class Module implements AutoloaderProviderInterface, ConfigProviderInterface
 {
     /**
      * Return an array for passing to Zend\Loader\AutoloaderFactory.
      *
      * @return array
      */
     public function getAutoloaderConfig()
     {
         return array(
             'Zend\Loader\StandardAutoloader' => array(
                 'namespaces' => array(
                     // Autoload all classes from namespace 'Template' from '/module/Template/src/Template'
                     __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                 )
             )
         );
     }
     /**
      * Returns configuration to merge with application configuration
      *
      * @return array|\Traversable
      */
     public function getConfig()
     {
         // Keeping config (which can be long) in an external file
         return include __DIR__ . '/config/module.config.php';
     }
 }
 