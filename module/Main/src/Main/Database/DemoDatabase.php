<?php

namespace Main\Database;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class DemoDatabase extends \SQLite3
{
    protected $isDevMode;
    protected $config;
    
    protected $conn;
    protected $entityManager;
    
    function __construct($dbPath)
    {
        parent::__construct($dbPath, SQLITE3_OPEN_READWRITE|SQLITE3_OPEN_CREATE);
        
        // Preparing annotation detection
        $this->isDevMode = true;
        $this->config = Setup::createAnnotationMetadataConfiguration(
            array(__DIR__."/../../src"), $this->isDevMode);
        
        // Creating entity manager
        $this->conn = array(
            'driver' => 'pdo_sqlite',
            'path' => $dbPath
        );
        
        $this->entityManager = EntityManager::create($this->conn, $this->config);
        
        // Checking table
        $this->checkTableCreation();
    }
    
    public function checkTableCreation() {
        
        $stmt1 = $this->getEntityManager()->getConnection()->prepare(
            "CREATE TABLE IF NOT EXISTS clients ("
            ."id INTEGER,"
            ."name VARCHAR(50) NOT NULL,"
            ."vatNumber VARCHAR(20) NOT NULL,"
            ."PRIMARY KEY(id));");
        $stmt1->execute();
        
        $stmt2 = $this->getEntityManager()->getConnection()->prepare(
            "CREATE TABLE IF NOT EXISTS orders ("
            ."id INTEGER,"
            ."client_id INTEGER,"
            ."FOREIGN KEY(client_id) REFERENCES clients(id),"
            ."PRIMARY KEY(id));");
        $stmt2->execute();
        
        $stmt3 = $this->getEntityManager()->getConnection()->prepare(
            "CREATE TABLE IF NOT EXISTS orderlines ("
            ."id INTEGER,"
            ."order_id INTEGER,"
            ."product VARCHAR(50) NOT NULL,"
            ."quantity INTEGER NOT NULL,"
            ."price DOUBLE PRECISION NOT NULL,"
            ."vat DOUBLE PRECISION NOT NULL,"
            ."FOREIGN KEY(order_id) REFERENCES orders(id),"
            ."PRIMARY KEY(id));");
        $stmt3->execute();
        
//        $tablesquery = $this->query("SELECT name FROM sqlite_master WHERE type='table';");
//        while ($table = $tablesquery->fetchArray(SQLITE3_ASSOC)) {
//            echo 'Table: '.$table['name'] . '<br />';
//        }
    }
    
    protected function dropTables() {
        $stmt = $this->getEntityManager()->getConnection()->prepare($this->dropSql);
        $stmt->execute();
    }
    
    public function getEntityManager() {
        return $this->entityManager;
    }
}
