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

    public function getByInstituicao(int $idInstituicao, string $ano) {
        
        $sql = SqlBuilder::build()->DATABASE(parent::getDbName())->
        SELECT()->
            addColum("f.idfechamento, f.datainicio, f.datafim, f.saldoinicial, f.entradas, f.saidas")->
            addColum("i.idinstituicao, i.cnpj, i.nome as nome_instituicao, i.email as email_instituicao, i.emailcontab, 
                i.datacadastro as data_cadastro_instituicao, i.idusuarioresp")->
            addColum("ti.idusuario as idtitular, ti.rg as rgtitular, ti.nome as nometitular, ti.email as emailtitular, 
                ti.datacadastro as datacadastrotitular")->
            FROM("fechamentos f")->
            INNERJOIN("instituicoes i")->ON("i.idinstituicao = f.idinstituicao")->
            INNERJOIN("usuarios ti")->ON("ti.idusuario = i.idusuarioresp")->
            WHERE("f.idinstituicao = :idinstituicao AND :ano BETWEEN YEAR(f.datainicio) AND YEAR(f.datafim)")->
        getSql();

        $params = [
            [':idinstituicao', $idInstituicao],
            [':ano', $ano]
        ];

        $result = null;

        try {
            $result = parent::getAll($sql, $params, new FechamentoConverter());
        }catch (Exception $e) {
            throw new Exception($e);
        }

        return $result;
    }

}
?>