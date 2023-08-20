<?php
namespace app\model\dao;

use app\model\dao\patterns\DaoPattern;
use app\model\dao\sql\SqlBuilder;
use app\model\entities\converter\EntradaConverter;
use app\model\entities\Entrada;
use Exception;

class EntradaDao extends DaoPattern {

    public function getById(int $idEntrada): Entrada {
        
        $sql = SqlBuilder::build()->DATABASE(parent::getDbName())->
        SELECT()->addColum("e.identrada, e.dataentrada, e.descricao as desc_entrada, e.valor")->
        addColum("i.idinstituicao, i.cnpj, i.nome as nome_instituicao, i.email as email_instituicao, i.emailcontab, 
            i.datacadastro as data_cadastro_instituicao, i.idusuarioresp")->
        addColum("u.idusuario, u.rg, u.nome as nome_user, u.email as email_user, u.datacadastro as data_cadastro_user")->
        addColum("ti.idusuario as idtitular, ti.rg as rgtitular, ti.nome as nometitular, ti.email as emailtitular, 
            ti.datacadastro as datacadastrotitular")->
        addColum("c.idcategoria, c.descricao as desc_categoria, c.tipo")->
        FROM("entradas e")->
        INNERJOIN("instituicoes i")->ON("i.idinstituicao = e.idinstituicao")->
        INNERJOIN("usuarios u")->ON("u.idusuario = e.idusuario")->
        LEFTJOIN("usuarios ti")->ON("ti.idusuario = i.idusuarioresp")->
        INNERJOIN("categorias c")->ON("c.idcategoria = e.idcategoria")->
        WHERE("e.identrada = :identrada")->getSql();

        $params = [
            [':identrada', $idEntrada]
        ];

        $result = null;

        try {
            $result = parent::getOne($sql, $params, new EntradaConverter());
        }catch (Exception $e) {
            throw new Exception($e);
        }

        return $result;
    }

    public function getByInstituicao(int $idInstituicao, string $dataInicio, string $dataFim) {
        
        $sql = SqlBuilder::build()->DATABASE(parent::getDbName())->
        SELECT()->addColum("e.identrada, e.dataentrada, e.descricao as desc_entrada, e.valor")->
        addColum("i.idinstituicao, i.cnpj, i.nome as nome_instituicao, i.email as email_instituicao, i.emailcontab, 
            i.datacadastro as data_cadastro_instituicao, i.idusuarioresp")->
        addColum("u.idusuario, u.rg, u.nome as nome_user, u.email as email_user, u.datacadastro as data_cadastro_user")->
        addColum("ti.idusuario as idtitular, ti.rg as rgtitular, ti.nome as nometitular, ti.email as emailtitular, 
            ti.datacadastro as datacadastrotitular")->
        addColum("c.idcategoria, c.descricao as desc_categoria, c.tipo")->
        FROM("entradas e")->
        INNERJOIN("instituicoes i")->ON("i.idinstituicao = e.idinstituicao")->
        INNERJOIN("usuarios u")->ON("u.idusuario = e.idusuario")->
        LEFTJOIN("usuarios ti")->ON("ti.idusuario = i.idusuarioresp")->
        INNERJOIN("categorias c")->ON("c.idcategoria = e.idcategoria")->
        WHERE("e.idinstituicao = :idinstituicao AND dataentrada BETWEEN :dataInicio AND :dataFim")->getSql();

        $params = [
            [':idinstituicao', $idInstituicao],
            [':dataInicio', $dataInicio],
            [':dataFim', $dataFim]
        ];

        $result = null;

        try {
            $result = parent::getAll($sql, $params, new EntradaConverter());
        }catch (Exception $e) {
            throw new Exception($e);
        }

        return $result;
    }

    public function saveEntrada(Entrada $entrada) {
        $sql = SqlBuilder::build()->
        DATABASE(parent::getDbName())->
        INSERT("entradas")->
        addColum("idinstituicao")->
        addColum("idusuario")->
        addColum("idcategoria")->
        addColum("dataentrada")->
        addColum("descricao")->
        addColum("valor")->
        INSERTVALUES(":idinstituicao, :idusuario, :idcategoria, :dataentrada, :descricao, :valor")->
        getSql();

        $params = [
            [':idinstituicao', $entrada->getInstituicao()->getIdInstituicao()],
            [':idusuario', $entrada->getUsuario()->getIdUsuario()],
            [':idcategoria', $entrada->getCategoria()->getIdCategoria()],
            [':dataentrada', $entrada->getDataEntrada()],
            [':descricao', $entrada->getDescricao()],
            [':valor', $entrada->getValor()]
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

    public function updateEntrada(Entrada $entrada) {
        
        $sql = SqlBuilder::build()->
        DATABASE(parent::getDbName())->
        UPDATE("entradas")->
        addColum("idusuario = :idusuario")->
        addColum("idcategoria = :idcategoria")->
        addColum("descricao = :descricao")->
        addColum("valor = :valor")->
        WHERE("identrada = :identrada")->
        getSql();

        $params = [
            [":idusuario", $entrada->getUsuario()->getIdUsuario()],
            [":idcategoria", $entrada->getCategoria()->getIdCategoria()],
            [":descricao", $entrada->getDescricao()],
            [":valor", $entrada->getValor()],
            [":identrada", $entrada->getIdEntrada()]
        ];

        $result = null;

        try {
            $result = parent::update($sql, $params);
        }catch (Exception $e) {
            throw new Exception($e);
        }

        return $result;
    }

}

?>