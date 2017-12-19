<?php 

namespace Blog\Service; 

use Blog\Model\PostInterface;

interface PostServiceInterface{
    /**
     * Should return all blog posts
     * @return array|PostInterface\
     */
    public function findAllPosts();

    /**
     * Should return a single Blog post
     * @param $id
     * @return PostInterface\
     */
    public function findPost($id);
}