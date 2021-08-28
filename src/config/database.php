<?php

abstract class Database {

    protected $connection;

    public function __construct()
    {
        $envPath = realpath(dirname(__FILE__) . '/../env.ini');
        $env = parse_ini_file($envPath);

        try {
            $this->connection = new PDO(
                $env['host'], 
                $env['username'], 
                $env['password']
            );
    
            return $this->connection;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

}