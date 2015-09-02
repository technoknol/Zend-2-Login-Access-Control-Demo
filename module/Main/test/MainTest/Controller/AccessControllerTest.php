<?php

namespace MainTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class AccessControllerTest extends AbstractHttpControllerTestCase
{
    public function setUp()
    {
        
        $this->setApplicationConfig(
            include '/../../../../../config/application.config.php'
        );
        parent::setUp();
    }
    
    public function testUserActionCanBeAccessed()
    {
        $this->dispatch('/restricted/user/user1');
        $this->assertResponseStatusCode(403);

        $this->assertModuleName('Main');
        $this->assertControllerName('Main\Controller\Access');
        $this->assertControllerClass('AccessController');
        $this->assertMatchedRouteName('restricted');
    }
    
    public function testAdminActionCanBeAccessed()
    {
        $this->dispatch('/restricted/admin');
        $this->assertResponseStatusCode(403);

        $this->assertModuleName('Main');
        $this->assertControllerName('Main\Controller\Access');
        $this->assertControllerClass('AccessController');
        $this->assertMatchedRouteName('restricted');
    }
}
