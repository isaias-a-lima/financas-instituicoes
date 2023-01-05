<?php
namespace app\controller;

use app\model\entities\Usuario;

class SessionController {
    const ID_USUARIO = "idUsuario";
    const NOME_USUARIO = "nomeUsuario";
    const INSTITUICOES = "instituicoes";

    public static function createSession(Usuario $usuario) {
        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION[self::ID_USUARIO] = $usuario->getIdUsuario();
        $_SESSION[self::NOME_USUARIO] = $usuario->getNome();
        $_SESSION[self::INSTITUICOES] = $usuario->getInstituicoes();
        return isset($_SESSION[self::ID_USUARIO]);
    }

    public static function hasSession() {
        if (!isset($_SESSION)) {
            session_start();
        }
        return isset($_SESSION[self::ID_USUARIO]);
    }

    public static function getSessionUser() {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (self::hasSession()) {
            $user = new Usuario();
            $user->setIdUsuario($_SESSION[self::ID_USUARIO]);
            $user->setNome($_SESSION[self::NOME_USUARIO]);
            $user->setInstituicoes($_SESSION[self::INSTITUICOES]);
            return $user;
        }
        return false;
    }

    public static function closeSession() {
        if (!isset($_SESSION)) {
            session_start();
        }
        session_unset();
        session_destroy();
        return !isset($_SESSION[self::ID_USUARIO]);
    }
}