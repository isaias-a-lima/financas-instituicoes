<?php
namespace app\model\dao;

use app\model\dao\patterns\DaoPattern;
use app\model\dao\sql\SqlBuilder;
use app\model\entities\converter\InstituicaoConverter;
use app\model\entities\Instituicao;
use Exception;

class InstituicaoDao extends DaoPattern {

    public function getAllInstituicoes($idUsuario) {

        $sql = SqlBuilder::build()->
            DATABASE(parent::getDbName())->
            SELECT()->addColum("i.idinstituicao")->addColum("i.cnpj")->addColum("i.nome")->
            addColum("i.email")->addColum("i.emailcontab")->addColum("i.datacadastro")->
            addColum("i.idusuarioresp")->
            addColum("ui.idusuario")->
            addColum("ui.funcao")->
            FROM("instituicoes i")->INNERJOIN("usuarios_instituicoes ui")->
            ON("ui.idinstituicao = i.idinstituicao")->
            WHERE("ui.idusuario = :idusuario")->
            ORDERBY("i.nome")->
            getSql();

        $params = [
            [":idusuario", $idUsuario]
        ];

        $result = null;

        try {
            $result = parent::getAll($sql, $params, new InstituicaoConverter());
        }catch (Exception $e) {
            throw new Exception($e);
        }

        return $result;
    }

    public function saveInstituicao(Instituicao $instituicao) {
        
        $sql = SqlBuilder::build()->
            DATABASE(parent::getDbName())->
            INSERT("instituicoes")->
            addColum("cnpj")->
            addColum("nome")->
            addColum("email")->
            addColum("emailcontab")->
            addColum("datacadastro")->
            addColum("idusuarioresp")->
            INSERTVALUES(":cnpj, :nome, :email, :emailcontab, :datacadastro, :idusuarioresp")->
            getSql();

        $params = [
            [':cnpj', $instituicao->getCnpj()],
            [':nome', $instituicao->getNome()],
            [':email', $instituicao->getEmail()],
            [':emailcontab', $instituicao->getEmailContab()],
            [':datacadastro', $instituicao->getDataCadastro()],
            [':idusuarioresp', $instituicao->getTitular()->getIdUsuario()]
        ];

        $result = false;

        try {
            $lastId = parent::save($sql, $params);

            if (isset($lastId) && $lastId !== false) {
                $this->saveUsuariosInstituicao($instituicao->getTitular()->getIdUsuario(), $lastId, null);
                $result = (int) $lastId;
            }
        }catch (Exception $e) {
            throw new Exception($e);
        }
        return $result;
    }

    public function saveUsuariosInstituicao(int $idUsuario, int $idInstituicao, $funcao) {

        $sql = SqlBuilder::build()->
            DATABASE(parent::getDbName())->
            INSERT("usuarios_instituicoes")->
            addColum("idusuario")->
            addColum("idinstituicao")->
            addColum("funcao")->
            INSERTVALUES(":idusuario, :idinstituicao, :funcao")->
            getSql();

        $params = [
            [":idusuario", $idUsuario],
            [":idinstituicao", $idInstituicao],
            [":funcao", (isset($funcao) ? $funcao : "Titular")]
        ];

        $result = false;

        try {
            $result = parent::save($sql, $params);
            if (isset($lastId) && $lastId !== false) {
                $result = (int) $lastId;
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }

        return $result;
    }

    public function getById($idInstituicao) {
        $sql = SqlBuilder::build()->
            DATABASE(parent::getDbName())->
            SELECT()->addColum("*")->FROM("instituicoes inst")->
            WHERE("inst.idinstituicao = :idinstituicao")->
            getSql();

        $params = [
            [":idinstituicao", $idInstituicao]
        ];

        $result = null;

        try {
            $result = parent::getOne($sql, $params, new InstituicaoConverter());
        }catch (Exception $e) {
            throw new Exception($e);
        }

        return $result;
    }

    public function updateInstituicao(Instituicao $instituicao) {
    
        $sql = SqlBuilder::build()->
        DATABASE(parent::getDbName())->
        UPDATE("instituicoes")->
        addColum("cnpj = :cnpj")->
        addColum("nome = :nome")->
        addColum("email = :email")->
        addColum("emailcontab = :emailcontab")->
        WHERE("idinstituicao = :idinstituicao")->
        getSql();

        $params = [
            [":cnpj", $instituicao->getCnpj()],
            [":nome", $instituicao->getNome()],
            [":email", $instituicao->getEmail()],
            [":emailcontab", $instituicao->getEmailContab()],
            [":idinstituicao", $instituicao->getIdInstituicao()]
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