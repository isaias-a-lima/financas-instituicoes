<?php
namespace app\model\dao;

use app\lib\Validacoes;
use app\model\dao\patterns\DaoPattern;
use app\model\dao\sql\SqlBuilder;
use app\model\entities\converter\BooleanConverter;
use app\model\entities\converter\FechamentoConverter;
use app\model\entities\Fechamento;
use Exception;

class FechamentoDAO extends DaoPattern {

    public function hasFechamento(int $idInstituicao,string $data):bool {
        $sql = SqlBuilder::build()->DATABASE(parent::getDbName())->
            SELECT()->
            addColum("count(f.idinstituicao) > 0 as chave")->
            FROM("fechamentos f")->
            WHERE("f.idinstituicao = :idinstituicao")->
            AND("f.datainicio > :data")->
            OR(":data between f.datainicio and f.datafim")->
        getSql();


        $params = [
            [':idinstituicao', $idInstituicao],
            [':data', $data]
        ];

        $result = false;

        try {
            $result = (bool) parent::getOne($sql, $params, new BooleanConverter());
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }

        return $result;
    }

    public function isFirstClosing(int $idInstituicao):bool {
        $sql = SqlBuilder::build()->DATABASE(parent::getDbName())->
            SELECT()->
            addColum("count(f.idinstituicao) = 0 as chave")->
            FROM("fechamentos f")->
            WHERE("f.idinstituicao = :idinstituicao")->
        getSql();

        $params = [
            [':idinstituicao', $idInstituicao]
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

    public function saveFechamento(Fechamento $fechamento) {
        $sql = SqlBuilder::build()->
            DATABASE(parent::getDbName())->
            INSERT("fechamentos")->
            addColum("idinstituicao")->
            addColum("datainicio")->
            addColum("datafim")->
            addColum("saldoinicial")->
            addColum("entradas")->
            addColum("saidas")->
            INSERTVALUES(":idinstituicao, :datainicio, :datafim, :saldoinicial, :entradas, :saidas")->
        getSql();

        $params = [
            [':idinstituicao', $fechamento->getInstituicao()->getIdInstituicao()],
            [':datainicio', $fechamento->getDataInicio()],
            [':datafim', $fechamento->getDataFim()],
            [':saldoinicial', $fechamento->getSaldoInicial()],
            [':entradas', $fechamento->getEntradas()],
            [':saidas', $fechamento->getSaidas()]
        ];

        $result = null;

        try {
            $result = parent::save($sql, $params);
        } catch(Exception $e) {
            throw new Exception($e);
        }

        return $result;
    }

    public function getFechamentoAnterior(int $idInstituicao, string $data) {
        $ano = (int) date("Y", strtotime($data));
        $mes = (int) date("m", strtotime($data));        

        $dataAnterior = date("Y-m-d", mktime(0, 0, 0, ($mes-1), 15, $ano));

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
            WHERE("f.idinstituicao = :idinstituicao")->
            AND(":data between f.datainicio and f.datafim")->
        getSql();


        $params = [
            [':idinstituicao', $idInstituicao],
            [':data', $dataAnterior]
        ];

        $result = null;

        try {
            $result = parent::getOne($sql, $params, new FechamentoConverter());
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }

        return $result;

    }

    public function getById(int $idFechamento) {       

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
            WHERE("f.idfechamento = :idfechamento")->
        getSql();

        $params = [
            [':idfechamento', $idFechamento]
        ];

        $result = null;

        try {
            $result = parent::getOne($sql, $params, new FechamentoConverter());
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }

        return $result;

    }

}
?>