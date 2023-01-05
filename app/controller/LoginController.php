<?php
namespace app\controller;

use app\lib\Constantes;

require_once Constantes::DEFAULT_MODEL_DIR . "/dao/LoginDao.php";

use app\lib\SecurityUtil;
use app\model\dao\LoginDao;
use Exception;

class LoginController {

    private LoginDao $loginDao;

    public function __construct() {
        $this->loginDao = new LoginDao();
    }

    public function login($email, $senha) {        
        try {
            
            if(empty($email) || empty($senha)) {
                throw new Exception("E-mail e senha são obrigatórios.");
            }

            $usuario = $this->loginDao->getUsuarioByEmail($email);
           
            if (!empty($usuario) && SecurityUtil::comparePassword($senha, $usuario->getSenha())) {                
                SessionController::createSession($usuario);
            } else {
                throw new Exception("Usuário ou senha inválidos.");
            }

            if (SessionController::hasSession()) {
                header("Location:./?p=2");
            }
        }catch (Exception $e) {
            throw new Exception($e->getMessage());
        }        
    }

    public function logout() {
        SessionController::closeSession();
    }
}