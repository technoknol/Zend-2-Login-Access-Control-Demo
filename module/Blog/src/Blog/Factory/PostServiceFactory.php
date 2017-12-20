<?php
/**
 * Created by PhpStorm.
 * User: webwerks
 * Date: 19/12/17
 * Time: 8:15 PM
 */

namespace Blog\Factory;


use Blog\Service\PostService;
use const MYSQLI_REFRESH_BACKUP_LOG;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PostServiceFactory implements FactoryInterface
{


    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
//        $realServiceLocator = $serviceLocator->getServiceLocator();
        $realServiceLocator = $serviceLocator->get('Blog\Mapper\PostMapperInterface');

        return new PostService($realServiceLocator);
    }
}