<?php

namespace Main\Database;

class DemoDatabase extends \SQLite3
{
    function __construct($dbPath)
    {
        $this->open($dbPath, SQLITE3_OPEN_READWRITE|SQLITE3_OPEN_CREATE);
    }
    
    function resetWithDemoData() {
        
    }
}
