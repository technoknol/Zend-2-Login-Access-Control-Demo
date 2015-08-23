<?php

namespace Main\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Form\Annotation\AnnotationBuilder;
use Main\Model\MyAuthAdaptor;
use Main\Model\User;

class AuthController extends AbstractActionController
{
    protected $form;
    protected $storage;
    protected $authservice;

    public function getAuthService()
    {
        if (!$this->authservice) {
            $this->authservice = $this->getServiceLocator()->get('MyAuthService');
        }
        return $this->authservice;
    }

    public function getSessionStorage()
    {
        if (!$this->storage) {
            $this->storage =  $this->getServiceLocator()->get('MyAuthStorage');
        }
        return $this->storage;
    }

    public function getForm()
    {
        if (!$this->form) {
            $user       = new User();
            $builder    = new AnnotationBuilder();
            $this->form = $builder->createForm($user);
        }
        return $this->form;
    }

    public function authenticateAction()
    {
        $form = $this->getForm();
        $request = $this->getRequest();
        
        if ($request->isPost()){
            $form->setData($request->getPost());
            if ($form->isValid()){
                
                $authAdapt = new MyAuthAdaptor(
                    $request->getPost('username'),
                    $request->getPost('password'));
                
                $this->getAuthService()->setAdapter($authAdapt);
                $result = $this->getAuthService()->authenticate();
                
                foreach($result->getMessages() as $message)
                {
                    $this->flashmessenger()->addMessage($message);
                }

                if ($result->isValid()) {
                    //check if it has rememberMe :
                    if ($request->getPost('rememberme') === 1 ) {
                        $this->getSessionStorage()->setRememberMe(1);
                        //set storage again
                        $this->getAuthService()->setStorage($this->getSessionStorage());
                    }
                    $this->getAuthService()->getStorage()->write($request->getPost('username'));
                }
            }
        }

        return $this->redirect()->toRoute('home');
    }

    public function logoutAction()
    {
        $this->getSessionStorage()->forgetMe();
        $this->getAuthService()->clearIdentity();
        
        return $this->redirect()->toRoute('home');
    }
}