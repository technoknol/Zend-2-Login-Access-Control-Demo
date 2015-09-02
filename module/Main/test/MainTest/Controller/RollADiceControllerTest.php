<?php

namespace MainTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class RollADiceControllerTest extends AbstractHttpControllerTestCase
{
    public function setUp()
    {
        
        $this->setApplicationConfig(
            include '/../../../../../config/application.config.php'
        );
        parent::setUp();
    }
    
    public function testRollADiceActionCanBeAccessed()
    {
        $this->dispatch('/roll-a-dice');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Main');
        $this->assertControllerName('Main\Controller\RollADice');
        $this->assertControllerClass('RollADiceController');
        $this->assertMatchedRouteName('roll-a-dice');
    }
    
    public function testRollADiceAjaxActionCanBeAccessed()
    {
        $this->dispatch('/roll-a-dice-ajax');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('Main');
        $this->assertControllerName('Main\Controller\RollADice');
        $this->assertControllerClass('RollADiceController');
        $this->assertMatchedRouteName('roll-a-dice-ajax');
    }
}
