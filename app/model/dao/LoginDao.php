<?php
namespace app\model\dao;

use app\lib\Constantes;
use app\model\dao\abstracts\DaoPattern;
use app\model\entities\converter\UsuarioConverter;

require_once Constantes::DEFAULT_MODEL_DIR . "/dao/Conexao.php";
require_once Constantes::DEFAULT_MODEL_DIR . "/dao/abstracts/DaoPattern.php";
require_once Constantes::DEFAULT_MODEL_DIR . "/entities/converter/UsuarioConverter.php";

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