<?php

namespace app\model\dao;

use PDO;
use PDOException;
use RuntimeException;

class Conexao {

    private $serverName;
    private $dbName;
    private $userName;
    private $password;
    private $conn;

    public function __construct() {    
            
        $this->serverName = "localhost";
        $this->dbName = "financas_instituicoes";
        $this->userName = "teste";
        $this->password = "teste";       
    }

    public function getConn() {
        try {
            $this->conn = new PDO("mysql:host=$this->serverName;$this->dbName", $this->userName, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);            
        } catch (PDOException $e) {
            throw new RuntimeException($e->getMessage());
        }
        return $this->conn;
    }

    public function closeConn() {
        $this->conn == null;
        return $this->conn;
    }

    public function getDbName() {
        return $this->dbName;
    }
}
