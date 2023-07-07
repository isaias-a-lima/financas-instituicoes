<?php
namespace app\model\dao\patterns;

use app\model\dao\sql\Query;
use app\model\dao\sql\SqlConsts;
use app\model\entities\converter\ConverterInterface;
use Exception;

class DaoPattern {

    private Query $query;

    public function __construct() {
        $this->query = new Query();
    }

    protected function getOne(string $sql, array $params, ConverterInterface $converter) {

        $result = false;

        try {
            $result = $this->query->createQuery($sql, $params, SqlConsts::SELECT, $converter);
            if (is_array($result) && count($result) > 0) {
                $result = $result[0];
            } else {
                $result = false;
            }

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return $result;
    }

    public function getAll(string $sql, array $params, ConverterInterface $converter) {

        $result = null;        
        
        try {
            $result = $this->query->createQuery($sql, $params, SqlConsts::SELECT, $converter);

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return $result;
    }

    public function save(string $sql, array $params) {

        $result = null;

        try {
            $result = $this->query->createSave($sql, $params, SqlConsts::INCLUDE);

        } catch (Exception $e) {
            throw new Exception($e);
        } 

        return $result;
    }

    public function update(string $sql, array $params) {
        $result = null;

        try {
            $result = $this->query->createSave($sql, $params, SqlConsts::UPDATE);

        } catch (Exception $e) {
            throw new Exception($e);
        }

        return $result;
    }

    protected function getDbName() {
        return $this->query->getDbName();
    }
}