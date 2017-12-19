<?php
 // Filename: /module/Blog/config/module.config.php
 return array(
     'controllers'=> array(
//        'invokables'=> array(
//            'Blog\Controller\List'=> 'Blog\Controller\ListController'
//        )
        'factories' => array(
            'Blog\Controller\List' => 'Blog\Factory\ListControllerFactory'
        )
     ),
     'router'=> array(
         'routes'=> array(
             'post'=> array(
                 'type'=> 'literal',
                 'options' => array(
                     'route'=> '/blog',
                     'defaults'=> array(
                         'controller'=>'Blog\Controller\List',
                         'action'=> 'index'
                     )
                 )
             )
         )
                     ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view'
        )
    ),
     'service_manager'=> array(
//        'invokables'=> array (
//            Blog\Service\PostServiceInterface::class => Blog\Service\PostService::class
//        )
         'factories' =>array(
            Blog\Service\PostServiceInterface::class => Blog\Factory\PostServiceFactory::class
        )
     )
 );