<?php
namespace app\model\dao;

use app\model\dao\patterns\DaoPattern;
use app\model\entities\converter\UsuarioConverter;
use app\model\entities\Usuario;
use Exception;

class UsuarioDao extends DaoPattern {

    public function getUsuarioByEmail($email) {
        $db = parent::getDb();

        $sql = "SELECT * FROM $db.usuarios u 
            INNER JOIN $db.usersecurity1 s ON s.idusuario = u.idusuario
            WHERE u.email = :email";

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
        $db = parent::getDb();

        $sql = "SELECT * FROM $db.usuarios u, $db.usersecurity1 s";

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
        $db = parent::getDb();

        $sql_user = "INSERT INTO $db.usuarios (rg, nome, email, datacadastro) 
            VALUES (:rg, :nome, :email, :datacadastro)";

        $params_user = [
            [':rg', $usuario->getRg()],
            [':nome', $usuario->getNome()],
            [':email', $usuario->getEmail()],
            [':datacadastro', $usuario->getDataCadastro()]
        ];

        $sql_security = "INSERT INTO $db.usersecurity1 (idusuario, senha) VALUES (:idusuario, :senha)";

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