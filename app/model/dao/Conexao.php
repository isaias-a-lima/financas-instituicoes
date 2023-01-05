<?php

namespace app\model\dao;

use PDO;
use PDOException;
use RuntimeException;

class Conexao {

    private $servername;
    private $dbname;
    private $username;
    private $password;
    private $conn;

    public function __construct() {
        
        $this->servername = "localhost";
        $this->dbname = "financas_instituicoes";
        $this->username = "teste";
        $this->password = "teste";

        try {
            $this->conn = new PDO("mysql:host=$this->servername;$this->dbname", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);            
        } catch (PDOException $e) {
            throw new RuntimeException($e->getMessage());
        }
    }

    public function getConn(){
        return $this->conn;
    }

    public function closeConn(){
        $this->conn == null;
    }

    public static function build() {
        $obj = new Conexao();
        return $obj;
    }
}
