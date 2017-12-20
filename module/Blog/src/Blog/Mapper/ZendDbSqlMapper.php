<?php
/**
 * Created by PhpStorm.
 * User: webwerks
 * Date: 20/12/17
 * Time: 11:16 AM
 */

namespace Blog\Mapper;


use Blog\Model\Post;
use Blog\Model\PostInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Sql;
use Zend\Hydrator\ClassMethods;
use Zend\Stdlib\Hydrator\HydrationInterface;

class ZendDbSqlMapper implements PostMapperInterface
{
    protected $dbAdapter;
    protected $hydrator;
    protected $postPrototype;

    public function __construct(AdapterInterface $dbAdapter, HydrationInterface $hydration, PostInterface $postPrototype)
    {
        $this->dbAdapter = $dbAdapter;
        $this->hydrator = $hydration;
        $this->postPrototype= $postPrototype;
    }

    /**
     * @param $id
     * @return PostInterface
     */
    public function find($id)
    {
        // TODO: Implement find() method.
    }

    /**
     * @return PostInterface
     */
    public function findAll()
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('posts');

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult()) {
//            $resultSet = new HydratingResultSet(new \Zend\Stdlib\Hydrator\ClassMethods(), new Post());
            $resultSet = new HydratingResultSet($this->hydrator, $this->postPrototype);
//    print_r($resultSet->initialize($result));
//    die;
//            \Zend\Debug\Debug::dump($resultSet->initialize($result));
            return $resultSet->initialize($result);
//            die();
        }
        return array();
//        \Zend\Debug\Debug::dump($result);die();
//        return $result;
    }
}