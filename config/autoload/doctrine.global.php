<?php 
return array(
    'doctrine' => array(
        'connection' => array(
            'orm_default' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                    'params' => array(
                        'host' => 'localhost',
                        'port' => '5432',
                        'dbname' => 's_zf2-demo',
                        'user' => 'root',
                        'password' => 'root',
                ),
            ),
        )
));