<?php
namespace app\model\dao\patterns;

use app\model\dao\Conexao;
use app\model\entities\converter\ConverterInterface;
use Exception;
use PDO;

class DaoPattern {

    private Conexao $conexao;
    protected string $database;

    public function __construct() {
        $this->conexao = new Conexao();
        $this->database = "financas_instituicoes";
    }

    public function getDb() {
        return $this->database;
    }

    public function getOne(string $sql, array $params, ConverterInterface $converter) {
        $result = null;
        try {
            $conn = $this->conexao->getConn();
            $stmt = $conn->prepare($sql);
            foreach ($params as $key => $value) {
                $stmt->bindParam($key, $value);
            }
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            if ($result = $stmt->fetchAll()) {
                $result = $converter->assocArrayToObject($result[0]);
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        } finally {
            $conn = null;
        }
        return $result;
    }

    public function getAll(string $sql, array $params, ConverterInterface $converter) {
        $result = null;
        try {
            $conn = $this->conexao->getConn();
            $stmt = $conn->prepare($sql);
            foreach ($params as $key => $value) {
                $stmt->bindParam($key, $value);
            }
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetchAll();
            /* if ($result = $stmt->fetchAll()) {
                $result = $converter->assocArrayToObject($result[0]);
            } */
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        } finally {
            $conn = null;
        }
        return $result;
    }
}