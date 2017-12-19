<?php
/**
 * Created by PhpStorm.
 * User: webwerks
 * Date: 19/12/17
 * Time: 6:20 PM
 */

namespace Blog\Model;

interface PostInterface
{
    /**
     * @return mixed
     */
    public function getId();

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @return string
     */
    public function getText();
}