<?php
/**
 * Created by PhpStorm.
 * User: webwerks
 * Date: 19/12/17
 * Time: 6:18 PM
 */

namespace Blog\Service;


use Blog\Mapper\PostMapperInterface;
use Blog\Model\Post;
use Blog\Model\PostInterface;

class PostService implements PostServiceInterface
{

//    protected $data = array(
//        array(
//            'id'    => 1,
//            'title' => 'Hello World #1',
//            'text'  => 'This is our first blog post!'
//        ),
//        array(
//            'id'     => 2,
//            'title' => 'Hello World #2',
//            'text'  => 'This is our second blog post!'
//        ),
//        array(
//            'id'     => 3,
//            'title' => 'Hello World #3',
//            'text'  => 'This is our third blog post!'
//        ),
//        array(
//            'id'     => 4,
//            'title' => 'Hello World #4',
//            'text'  => 'This is our fourth blog post!'
//        ),
//        array(
//            'id'     => 5,
//            'title' => 'Hello World #5',
//            'text'  => 'This is our fifth blog post!'
//        )
//    );

    public function __construct(PostMapperInterface $postMapper)
    {
        $this->postMapper = $postMapper;
    }

    /**
     * Should return all blog posts
     * @return array|PostInterface\
     */
    public function findAllPosts()
    {
        return $this->postMapper->findAll();
//        $posts = [];
//        foreach ($this->data as $index=>$post){
//            $posts[] = $this->findPost($index);
//        }
//        return $posts;
    }

    /**
     * Should return a single Blog post
     * @param $id
     * @return PostInterface\
     */
    public function findPost($id)
    {
        return $this->postMapper->find($id);
//        $postData = $this->data[$id];
//
//        $model = new Post();
//        $model->setId($postData['id']);
//        $model->setTitle($postData['title']);
//        $model->setText($postData['text']);
//
//        return $model;
    }
}