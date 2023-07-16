<?php
namespace app\model\dao;

use app\model\dao\patterns\DaoPattern;
use app\model\dao\sql\SqlBuilder;
use app\model\entities\converter\CategoriaConverter;
use Exception;

class CategoriaDAO extends DaoPattern {

    public function getByTipo(string $tipo) {
        $sql = SqlBuilder::build()->DATABASE(parent::getDbName())->
        SELECT()->addColum("c.*")->
        FROM("categorias c")->
        WHERE("c.tipo = :tipo")->getSql();

        $params = [
            [':tipo', $tipo]
        ];

        $result = null;

        try {
            $result = parent::getAll($sql, $params, new CategoriaConverter());
        }catch (Exception $e) {
            throw new Exception($e);
        }

        return $result;
    }

}
?>