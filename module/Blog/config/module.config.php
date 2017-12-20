<?php
// Filename: /module/Blog/config/module.config.php
use Blog\Mapper\PostMapperInterface;
use Zend\Db\Adapter\AdapterServiceFactory;

return array(
    'db' => array(
        'driver' => 'Pdo',
        'username' => 'root',
        'password' => 'root',
        'dsn'=> 'mysql:dbname=s_zf2-demo;host=localhost',
        'driver_options' => array(
            \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        )
    ),
    'controllers' => array(
//        'invokables'=> array(
//            'Blog\Controller\List'=> 'Blog\Controller\ListController'
//        )
        'factories' => array(
            'Blog\Controller\List' => 'Blog\Factory\ListControllerFactory'
        )
    ),
    'router' => array(
        'routes' => array(
            'post' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/blog',
                    'defaults' => array(
                        'controller' => 'Blog\Controller\List',
                        'action' => 'index'
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
    'service_manager' => array(
//        'invokables'=> array (
//            Blog\Service\PostServiceInterface::class => Blog\Service\PostService::class
//        )
        'factories' => array(
            PostMapperInterface::class => Blog\Factory\ZendDbSqlMapperFactory::class,
            Blog\Service\PostServiceInterface::class => Blog\Factory\PostServiceFactory::class,
            Zend\Db\Adapter\Adapter::class => AdapterServiceFactory::class
        )
    )
);