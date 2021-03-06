<?php

namespace Main\Service;

// Simple service returning a random number like a dice would

class RollADiceService
{
    CONST MIN_VALUE = 1;
    CONST MAX_VALUE = 6;
    
    public function getDiceResult() {
        return rand(RollADiceService::MIN_VALUE,RollADiceService::MAX_VALUE);
    }
}
