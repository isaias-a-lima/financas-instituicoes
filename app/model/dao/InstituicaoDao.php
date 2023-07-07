<?php
namespace app\model\dao;

use app\model\dao\patterns\DaoPattern;
use app\model\dao\sql\SqlBuilder;
use app\model\entities\converter\InstituicaoConverter;
use app\model\entities\Instituicao;
use Exception;

class InstituicaoDao extends DaoPattern {

    public function getAllInstituicoes($idUsuarioResp) {

        $sql = SqlBuilder::build()->
            DATABASE(parent::getDbName())->
            SELECT()->addColum("*")->FROM("instituicoes inst")->
            WHERE("inst.idusuarioresp = :idusuarioresp")->
            ORDERBY("inst.nome")->
            getSql();

        $params = [
            [":idusuarioresp", $idUsuarioResp]
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
            [':idusuarioresp', $instituicao->getIdUsuarioResp()]
        ];

        $result = false;

        try {
            $lastId = parent::save($sql, $params);

            if (isset($lastId) && $lastId !== false) {
                $result = (int) $lastId;
            }
        }catch (Exception $e) {
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