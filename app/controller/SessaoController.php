<?php
namespace app\controller;

use app\model\entities\Usuario;

class SessaoController {

    public static function criarSessao(Usuario $usuario) {
        session_start();
        $_SESSION['idUsuario'] = $usuario->getIdUsuario();
        $_SESSION['nomeUsuario'] = $usuario->getNome();
        $_SESSION['instituicoes'] = $usuario->getInstituicoes();
    }

    public static function encerrarSessao() {
        session_unset();
        session_destroy();
    }
}