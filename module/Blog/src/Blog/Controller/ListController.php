<?php 

namespace Blog\Controller; 

use Blog\Service\PostServiceInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ListController extends AbstractActionController {

    /**
     * @var PostServiceInterface
     */
    protected $postService;

    public function __construct(PostServiceInterface $postService) {
        $this->postService = $postService;
    }

    public function indexAction() {
        return (array(
            'posts' => $this->postService->findAllPosts()
        ));
    }
}