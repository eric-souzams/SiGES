<?php

class Database {

    public function getConnection() {
        $envPath = realpath(dirname(__FILE__) . '/../env.ini');
        $env = parse_ini_file($envPath);

        $connection = new PDO(
            $env['host'], 
            $env['username'], 
            $env['password']
        );

        return $connection;
    }

    public function getAll() {
        $connection = $this->getConnection();

        $query = $connection->prepare(
            "SELECT * FROM users"
        );

        $query->execute();

        $users = $query->fetchAll(PDO::FETCH_ASSOC) ?? [false];

        return $users ? $users : [];
    }

}