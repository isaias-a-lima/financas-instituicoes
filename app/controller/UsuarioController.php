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

    /**
     * Retorna um objeto do tipo Usuario
     * @return Usuario|false
     */
    public function getUsuario(int $idUsuario) {
        $result = false;
        try {
            if (!isset($idUsuario)) {
                throw new Exception("Nenhum usuário selecionado.");
            }

            $result = $this->usuarioDao->getUsuarioById($idUsuario);

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return $result;
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

    public function updateUsuario(Usuario $usuario) {
        $result = false;
        try {
            if(!isset($usuario)) {
                throw new Exception("Usuário é obrigatório.");
            }

            $result = $this->usuarioDao->updateUsuario($usuario);

            if(is_int($result) && $result > 0) {
                $codPage = RenderController::PAGES['HOME']['cod'];
                $link = "Location:./?p=$codPage";
                header($link);
            } else {
                throw new Exception("Nenhuma alteração registrada.");
            }

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return $result;
    }

}