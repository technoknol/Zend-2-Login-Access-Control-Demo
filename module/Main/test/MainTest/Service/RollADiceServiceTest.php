<?php

namespace MainTest\Service;

use Main\Service\RollADiceService;

class RollADiceServiceTest extends \PHPUnit_Framework_TestCase
{

    public function testGetDiceResult()
    {
        $rads = new RollADiceService();
        $res = $rads->getDiceResult();
        
        $this->assertTrue(is_int($res));
        $this->assertTrue($res>=RollADiceService::MIN_VALUE);
        $this->assertTrue($res<=RollADiceService::MAX_VALUE);
    }
    
}
