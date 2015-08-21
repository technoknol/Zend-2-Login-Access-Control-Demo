<?php
// Filename: /module/_MainTemplate/config/module.config.php
return array(
    // Telling where the views are
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // For the view directory, the controller name will be stripped
    // of 'Controller' and lower-cased -> myy
    'controllers' => array(
        'invokables' => array(
            'Template\Controller\MyCtrl' => 'Template\Controller\MyyController'
        )
    ),
    // This lines opens the configuration for the RouteManager
    'router' => array(
        // Open configuration for all possible routes
        'routes' => array(
            // Define a new route called "template"
            'template' => array(
                // Define the routes type to be "Zend\Mvc\Router\Http\Literal",
                // which is basically just a string
                'type' => 'literal',
                // Configure the route itself
                'options' => array(
                    // Listen to "/myroute" as uri
                    'route'    => '/myroute',
                    // Define default controller and action to be called when this route is matched
                    'defaults' => array(
                        'controller' => 'Template\Controller\MyCtrl',
                        'action'     => 'index',
                    )
                )
            )
        )
    )
);