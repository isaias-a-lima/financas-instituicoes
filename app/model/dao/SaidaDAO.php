<?php
namespace app\model\dao;

use app\model\dao\patterns\DaoPattern;
use app\model\dao\sql\SqlBuilder;
use app\model\entities\converter\GenericConverter;
use app\model\entities\converter\SaidaConverter;
use app\model\entities\Saida;
use Exception;

class SaidaDao extends DaoPattern {

    public function getById(int $idSaida): Saida {
        
        $sql = SqlBuilder::build()->DATABASE(parent::getDbName())->
        SELECT()->addColum("s.idsaida, s.datasaida, s.descricao as desc_saida, s.valor, s.numdoc")->
        addColum("i.idinstituicao, i.cnpj, i.nome as nome_instituicao, i.email as email_instituicao, i.emailcontab, 
            i.datacadastro as data_cadastro_instituicao, i.idusuarioresp")->
        addColum("u.idusuario, u.rg, u.nome as nome_user, u.email as email_user, u.datacadastro as data_cadastro_user")->
        addColum("ti.idusuario as idtitular, ti.rg as rgtitular, ti.nome as nometitular, ti.email as emailtitular, 
            ti.datacadastro as datacadastrotitular")->
        addColum("c.idcategoria, c.descricao as desc_categoria, c.tipo")->
        FROM("saidas s")->
        INNERJOIN("instituicoes i")->ON("i.idinstituicao = s.idinstituicao")->
        INNERJOIN("usuarios u")->ON("u.idusuario = s.idusuario")->
        LEFTJOIN("usuarios ti")->ON("ti.idusuario = i.idusuarioresp")->
        INNERJOIN("categorias c")->ON("c.idcategoria = s.idcategoria")->
        WHERE("s.idsaida = :idsaida")->getSql();

        $params = [
            [':idsaida', $idSaida]
        ];

        $result = null;

        try {
            $result = parent::getOne($sql, $params, new SaidaConverter());
        }catch (Exception $e) {
            throw new Exception($e);
        }

        return $result;
    }

    public function getByInstituicao(int $idInstituicao, string $dataInicio, string $dataFim) {
        
        $sql = SqlBuilder::build()->DATABASE(parent::getDbName())->
        SELECT()->addColum("s.idsaida, s.datasaida, s.descricao as desc_saida, s.valor, s.numdoc")->
        addColum("i.idinstituicao, i.cnpj, i.nome as nome_instituicao, i.email as email_instituicao, i.emailcontab, 
            i.datacadastro as data_cadastro_instituicao, i.idusuarioresp")->
        addColum("u.idusuario, u.rg, u.nome as nome_user, u.email as email_user, u.datacadastro as data_cadastro_user")->
        addColum("ti.idusuario as idtitular, ti.rg as rgtitular, ti.nome as nometitular, ti.email as emailtitular, 
            ti.datacadastro as datacadastrotitular")->
        addColum("c.idcategoria, c.descricao as desc_categoria, c.tipo")->
        FROM("saidas s")->
        INNERJOIN("instituicoes i")->ON("i.idinstituicao = s.idinstituicao")->
        INNERJOIN("usuarios u")->ON("u.idusuario = s.idusuario")->
        LEFTJOIN("usuarios ti")->ON("ti.idusuario = i.idusuarioresp")->
        INNERJOIN("categorias c")->ON("c.idcategoria = s.idcategoria")->
        WHERE("s.idinstituicao = :idinstituicao AND datasaida BETWEEN :dataInicio AND :dataFim")->getSql();

        $params = [
            [':idinstituicao', $idInstituicao],
            [':dataInicio', $dataInicio],
            [':dataFim', $dataFim]
        ];

        $result = null;

        try {
            $result = parent::getAll($sql, $params, new SaidaConverter());
        }catch (Exception $e) {
            throw new Exception($e);
        }

        return $result;
    }

    public function saveSaida(Saida $saida) {
        $sql = SqlBuilder::build()->
        DATABASE(parent::getDbName())->
        INSERT("saidas")->
        addColum("idinstituicao")->
        addColum("idusuario")->
        addColum("idcategoria")->
        addColum("datasaida")->
        addColum("descricao")->
        addColum("valor")->
        addColum("numdoc")->
        INSERTVALUES(":idinstituicao, :idusuario, :idcategoria, :datasaida, :descricao, :valor, :numdoc")->
        getSql();

        $params = [
            [':idinstituicao', $saida->getInstituicao()->getIdInstituicao()],
            [':idusuario', $saida->getUsuario()->getIdUsuario()],
            [':idcategoria', $saida->getCategoria()->getIdCategoria()],
            [':datasaida', $saida->getDataSaida()],
            [':descricao', $saida->getDescricao()],
            [':valor', $saida->getValor()],
            [':numdoc', $saida->getNumDoc()]
        ];        
        
        $result = false;

        try {
            $lastId = parent::save($sql, $params);

            if (isset($lastId)) {
                $result = (int) $lastId;
            }
        }catch (Exception $e) {
            throw new Exception($e);
        }
        return $result;
    }

    public function updateSaida(Saida $saida) {
        
        $sql = SqlBuilder::build()->
        DATABASE(parent::getDbName())->
        UPDATE("saidas")->
        addColum("idusuario = :idusuario")->
        addColum("idcategoria = :idcategoria")->
        addColum("descricao = :descricao")->
        addColum("valor = :valor")->
        addColum("numdoc = :numdoc")->
        WHERE("idsaida = :idsaida")->
        getSql();

        $params = [
            [":idusuario", $saida->getUsuario()->getIdUsuario()],
            [":idcategoria", $saida->getCategoria()->getIdCategoria()],
            [":descricao", $saida->getDescricao()],
            [":valor", $saida->getValor()],
            [":idsaida", $saida->getIdSaida()],
            [":numdoc", $saida->getNumDoc()]
        ];

        $result = null;

        try {
            $result = parent::update($sql, $params);
        }catch (Exception $e) {
            throw new Exception($e);
        }

        return $result;
    }

    public function getSomaById(int $idInstituicao, string $dataInicio, string $dataFim) {
        $sql = SqlBuilder::build()->DATABASE(parent::getDbName())->
        SELECT()->
        addColum("SUM(valor) as coluna")->
        FROM("saidas s")->
        WHERE("s.idinstituicao = :idinstituicao AND datasaida BETWEEN :dataInicio AND :dataFim")->
        getSql();

        $params = [
            [':idinstituicao', $idInstituicao],
            [':dataInicio', $dataInicio],
            [':dataFim', $dataFim]
        ];

        $result = null;

        try {
            $result = parent::getOne($sql, $params, new GenericConverter());
        }catch (Exception $e) {
            throw new Exception($e);
        }

        return $result;
    }

}

?>