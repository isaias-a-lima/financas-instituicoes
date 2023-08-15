<?php
namespace app\model\dao;

use app\model\dao\patterns\DaoPattern;
use app\model\dao\sql\SqlBuilder;
use app\model\entities\converter\BooleanConverter;
use app\model\entities\converter\UsuarioConverter;
use app\model\entities\Usuario;
use Exception;

class UsuarioDao extends DaoPattern {

    public function insertChaveResetSenha(Usuario $usuario, $chave, $localizacao) {
        try {
            $sql_chave = SqlBuilder::build()->DATABASE(parent::getDbName())->
                    INSERT("historico_reset_senha")->
                    addColum("idusuario")->
                    addColum("chave")->
                    addColum("datasolicitacao")->
                    addColum("dataexpiracao")->
                    addColum("localizacao")->
                    INSERTVALUES(":idusuario, :chave, :datasolicitacao, :dataexpiracao, :localizacao")->
                    getSql();

            $expiracao = date("Y-m-d", strtotime("+ 1 day"));

            $params_chave = [
                [':idusuario', $usuario->getIdUsuario()],
                [':chave', $chave],
                [':datasolicitacao', date("Y-m-d")],
                [':dataexpiracao', $expiracao],
                [':localizacao', $localizacao]
            ];

            $lastId = parent::save($sql_chave, $params_chave);

            return $lastId;

        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    public function getUsuarioByEmail($email): Usuario {

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

    public function verifyChave(int $idUsuario) {

        $sql = SqlBuilder::build()->
        DATABASE(parent::getDbName())->
        SELECT()->addColum("hrs.chave")->
        FROM("historico_reset_senha hrs")->        
        WHERE("hrs.idusuario = :idusuario")->
        AND("curdate() between hrs.datasolicitacao and hrs.dataexpiracao")->
        ORDERBY("hrs.idhistorico desc")->
        getSql();

        $params = [
            [':idusuario', $idUsuario]
        ];

        $result = false;

        try {
            $result = parent::getOne($sql, $params, new BooleanConverter());
        }catch (Exception $e) {
            throw new Exception($e);
        }

        return $result;
    }

    public function getUsuarioById(int $idUsuario) {
        $result = false;

        try {
            if (!isset($idUsuario)) {
                throw new Exception("Nenhum usuário selecionado.");
            }
            
            $sql = SqlBuilder::build()->
                DATABASE(parent::getDbName())->
                SELECT()->
                addColum("u.idusuario")->
                addColum("u.rg")->
                addColum("u.nome")->
                addColum("u.email")->
                addColum("u.datacadastro")->
                addColum("us.senha")->
                FROM("usuarios u")->
                INNERJOIN("usersecurity1 us")->
                ON("us.idusuario = u.idusuario")->
                WHERE("u.idusuario = :idusuario")->
                getSql();
                
            $params = [
                [":idusuario", $idUsuario]
            ];

            $result = parent::getOne($sql, $params, new UsuarioConverter());

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
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

    public function updateUsuario(Usuario $usuario) {

        $result = false;
        
        $sql = SqlBuilder::build()->
            DATABASE(parent::getDbName())->
            UPDATE("usuarios")->
            addColum("rg = :rg")->
            addColum("nome = :nome")->
            addColum("email = :email")->
            WHERE("idusuario = :idusuario")->
            getSql();

        $params = [
            [":idusuario", $usuario->getIdUsuario()],
            [":rg", $usuario->getRg()],
            [":nome", $usuario->getNome()],
            [":email", $usuario->getEmail()]
        ];
        
        try {
            $result = parent::update($sql, $params);

        } catch (Exception $e) {
            throw new Exception($e);
        }

        return $result;
    }

    public function updateSenha(int $idUsuario, string $senha) {
        $result = false;

        $sql = SqlBuilder::build()->
            DATABASE(parent::getDbName())->
            UPDATE("usersecurity1")->
            addColum("senha = :senha")->           
            WHERE("idusuario = :idusuario")->
            getSql();

        $params = [
            [":idusuario", $idUsuario],
            [":senha", $senha]
        ];
        try{
            $result = parent::update($sql, $params);

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return $result;
    }

}