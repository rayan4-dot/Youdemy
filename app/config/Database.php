<?php

namespace App\Config;

use PDO;
use PDOException;

class Database {

    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "youdemy"; 
    private $conn;

    public function __construct()
    {
        try {
            $this->conn = new PDO("mysql:host={$this->servername};dbname={$this->dbname}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}


