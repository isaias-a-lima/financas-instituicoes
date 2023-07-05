<?php

namespace app\model\dao\sql;

use app\model\dao\Conexao;
use app\model\entities\converter\ConverterInterface;
use Exception;
use PDO;

class Query
{

    private Conexao $conexao;
    protected string $dbName;

    public function __construct()
    {
        $this->conexao = new Conexao();
        $this->dbName = $this->conexao->getDbName();
    }

    public function createQuery(string $sql, array $params, int $sqlConst, ConverterInterface $converter)
    {
        $result = null;

        try {
            $conn = $this->conexao->getConn();

            $stmt = $conn->prepare($sql);

            if (isset($params) && count($params) > 0) {
                for ($i = 0; $i < count($params); $i++) {
                    $stmt->bindParam($params[$i][0], $params[$i][1]);
                }
            }

            $stmt->execute();

            if (SqlConsts::SELECT == $sqlConst) {
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                if ($result = $stmt->fetchAll()) {
                    $result = isset($converter) ? $converter->arrayListToObjectList($result) : $result;
                }
            } else {
                $result = $stmt->rowCount();
            }

        } catch (Exception $e) {
            throw new Exception($e);
        } finally {
            $conn = $this->conexao->closeConn();
        }

        return $result;
    }

    public function getDbName() {
        return $this->dbName;
    }

    public function createSave (string $sql, array $params, int $sqlConst) {
        $result = null;

        try {
            $conn = $this->conexao->getConn();

            $stmt = $conn->prepare($sql);

            if (isset($params) && count($params) > 0) {               
                for ($i = 0; $i < count($params); $i++) {
                    $stmt->bindParam($params[$i][0], $params[$i][1]);
                }
            }

            $stmt->execute();

            $result = $sqlConst == SqlConsts::INCLUDE ? $conn->lastInsertId() : $stmt->rowCount();

        } catch (Exception $e) {
            throw new Exception($e);
        } finally {
            $conn = $this->conexao->closeConn();
        }

        return $result;
    }
}
