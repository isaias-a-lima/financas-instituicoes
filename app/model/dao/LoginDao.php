<?php
namespace app\model\dao;

use app\model\dao\patterns\DaoPattern;
use app\model\entities\converter\UsuarioConverter;

use Exception;

class LoginDao extends DaoPattern {

    public function getUsuarioByEmail($email) {
        $db = parent::getDb();
        $sql = "SELECT * FROM $db.usuarios u, $db.usersecurity1 s WHERE u.email = :email";
        $params = [':email'=>$email];
        $result = null;
        try {
            $result = parent::getOne($sql, $params, new UsuarioConverter());
        }catch (Exception $e) {
            throw new Exception($e);
        }
        return $result;
    }

}