<?php
/**
 * Created by PhpStorm.
 * User: webwerks
 * Date: 19/12/17
 * Time: 8:05 PM
 */

namespace Blog\Mapper;

use Blog\Model\PostInterface;

/**
 * Interface PostMapperInterface
 * @package Blog\Mapper
 */
interface PostMapperInterface
{

    /**
     * @param $id
     * @return PostInterface
     */
    public function find($id);

    /**
     * @return PostInterface
     */
    public function findAll();
}