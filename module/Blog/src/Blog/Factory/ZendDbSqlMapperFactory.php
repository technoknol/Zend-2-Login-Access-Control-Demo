<?php
/**
 * Created by PhpStorm.
 * User: webwerks
 * Date: 20/12/17
 * Time: 11:48 AM
 */

namespace Blog\Factory;

use Blog\Mapper\PostMapperInterface;
use Blog\Mapper\ZendDbSqlMapper;
use Blog\Model\Post;
use function preg_split;
use Zend\Db\Adapter\Adapter;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

class ZendDbSqlMapperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
//        return new ZendDbSqlMapper($serviceLocator->get(Adapter::class));
        return new ZendDbSqlMapper($serviceLocator->get(Adapter::class), new ClassMethods(false), new Post());
//        return new ZendDbSqlMapper(
//            $serviceLocator->get('Zend\Db\Adapter\Adapter'),
//            new ClassMethods(false),
//            new Post()
//        );
    }

}