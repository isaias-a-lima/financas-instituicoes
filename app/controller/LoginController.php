<?php
namespace app\controller;

use app\lib\SecurityUtil;
use app\model\dao\LoginDao;
use Exception;

class LoginController {

    private LoginDao $loginDao;
    private SessionController $sessao;

    public function __construct() {
        $this->loginDao = new LoginDao();
        $this->sessao = SessionController::getInstance();
    }

    public function login($email, $senha) {        
        try {
            
            if(empty($email) || empty($senha)) {
                throw new Exception("E-mail e senha são obrigatórios.");
            }

            $usuario = $this->loginDao->getUsuarioByEmail($email);
           
            if (!empty($usuario) && SecurityUtil::comparePassword($senha, $usuario->getSenha())) {                
                $this->sessao->createSession($usuario);
            } else {
                $usuario = null;
                throw new Exception("Usuário ou senha inválidos.");
            }

            if ($this->sessao->hasSession($this->sessao::ID_USUARIO)) {
                $codPage = RenderController::PAGES['HOME']['cod'];                
                echo "<script>location.replace('./?p=$codPage');</script>";
            }
        }catch (Exception $e) {
            throw new Exception($e->getMessage());
        }        
    }

    public function logout() {
        $this->sessao->closeSession();
    }
}