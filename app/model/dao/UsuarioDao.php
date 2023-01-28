<?php
namespace app\model\dao;

use app\model\dao\patterns\DaoPattern;
use app\model\dao\sql\SqlBuilder;
use app\model\entities\converter\UsuarioConverter;
use app\model\entities\Usuario;
use Exception;

class UsuarioDao extends DaoPattern {

    public function getUsuarioByEmail($email) {

        $sql = SqlBuilder::build()->DATABASE(parent::getDbName())->
            SELECT()->addColum("*")->
            FROM("usuarios u")->
            INNERJOIN("usersecurity1 s")->ON("s.idusuario = u.idusuario")->
            WHERE("u.email = :email")->getSql();

        $params = [
            [':email', $email]
        ];

        $result = null;

        try {
            $result = parent::getOne($sql, $params, new UsuarioConverter());
        }catch (Exception $e) {
            throw new Exception($e);
        }

        return $result;
    }

    public function getAllUsuarios() {

        $sql = SqlBuilder::build()->
            DATABASE(parent::getDbName())->
            SELECT()->addColum("*")->
            FROM("usuarios u")->getSql();

        $params = [];

        $result = null;

        try {
            $result = parent::getAll($sql, $params, new UsuarioConverter());
        }catch (Exception $e) {
            throw new Exception($e);
        }

        return $result;
    }

    public function saveUsuario(Usuario $usuario) {

        $sql_user = SqlBuilder::build()->
            DATABASE(parent::getDbName())->
            INSERT("usuarios")->
            addColum("rg")->
            addColum("nome")->
            addColum("email")->
            addColum("datacadastro")->
            INSERTVALUES(":rg, :nome, :email, :datacadastro")->getSql();

        $params_user = [
            [':rg', $usuario->getRg()],
            [':nome', $usuario->getNome()],
            [':email', $usuario->getEmail()],
            [':datacadastro', $usuario->getDataCadastro()]
        ];
        
        $sql_security = SqlBuilder::build()->
            DATABASE(parent::getDbName())->
            INSERT("usersecurity1")->
            addColum("idusuario")->
            addColum("senha")->
            INSERTVALUES(":idusuario, :senha")->
            getSql();

        $params_security = [];

        $result = false;

        try {
            $lastId = parent::save($sql_user, $params_user);

            if (isset($lastId)) {
                $lastId = (int) $lastId;

                array_push($params_security, [':idusuario', $lastId]);
                array_push($params_security, [':senha', $usuario->getSenha()]);

                $result = parent::save($sql_security, $params_security);
            }
        }catch (Exception $e) {
            throw new Exception($e);
        }
        return $result;
    }

}