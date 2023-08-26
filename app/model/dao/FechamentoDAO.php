<?php
namespace app\model\dao;

use app\model\dao\patterns\DaoPattern;
use app\model\dao\sql\SqlBuilder;
use app\model\entities\converter\BooleanConverter;
use app\model\entities\converter\FechamentoConverter;
use Exception;

class FechamentoDAO extends DaoPattern {

    public function hasFechamento(int $idInstituicao,string $dataAtual):bool {
        $sql = SqlBuilder::build()->DATABASE(parent::getDbName())->
            SELECT()->
            addColum("count(f.idinstituicao) > 0 as chave")->
            FROM("fechamentos f")->
            WHERE("f.idinstituicao = :idinstituicao")->
            AND(":dataatual between f.datainicio and f.datafim")->
        getSql();


        $params = [
            [':idinstituicao', $idInstituicao],
            [':dataatual', $dataAtual]
        ];

        $result = false;

        try {
            $result = (bool) parent::getOne($sql, $params, new BooleanConverter());
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }

        return $result;
    }

}
?>