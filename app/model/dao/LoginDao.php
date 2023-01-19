<?php
namespace app\model\dao;

use Exception;

class LoginDao {

    private UsuarioDao $usuario;

    public function __construct() {
        $this->usuario = new UsuarioDao();
    }

    public function getUsuarioByEmail($email) {        
        $result = null;
        try {
            $result = $this->usuario->getUsuarioByEmail($email);
        }catch (Exception $e) {
            throw new Exception($e);
        }
        return $result;
    }

}