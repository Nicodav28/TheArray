<?php

namespace Config;

use PDO;

class Database
{
    private $host;
    private $dbPort;
    private $dbName;
    private $dbUserName;
    private $dbPass;

    public function __construct()
    {
        $this->host = $_ENV['DB_HOST'] ?? null;
        $this->dbPort = $_ENV['DB_PORT'] ?? null;
        $this->dbName = $_ENV['DB_DATABASE'] ?? null;
        $this->dbUserName = $_ENV['DB_USERNAME'] ?? null;
        $this->dbPass = $_ENV['DB_PASSWORD'] ?? null;
    }

    public function performConnection()
    {
        try {
            $exeConnection = new PDO(
                "mysql:host=$this->host;
                port=$this->dbPort;
                dbname=$this->dbName",
                $this->dbUserName,
                $this->dbPass
            );

            $exeConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $exeConnection;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
