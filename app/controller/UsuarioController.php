<?php
namespace app\controller;

use app\model\dao\UsuarioDao;
use app\model\entities\Usuario;
use Exception;

class UsuarioController {

    private UsuarioDao $usuarioDao;

    public function __construct() {
        $this->usuarioDao = new UsuarioDao();
    }

    public function saveUsuario(Usuario $usuario) {
        
        try {
            if (!isset($usuario)) {
                throw new Exception("Usuário é obrigatório.");
            }

            $result = $this->usuarioDao->saveUsuario($usuario);

            if (isset($result) && $result !== false) {
                $codPage = RenderController::PAGES['LOGIN']['cod'];
                $link = "<a href='./?p=$codPage'>Clique aqui para entrar.</a>";
                $msg = "Usuário cadastrado com sucesso! $link";
                throw new Exception($msg);
            }

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

}