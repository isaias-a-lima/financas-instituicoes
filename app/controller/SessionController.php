<?php
namespace app\controller;

use app\model\entities\Usuario;

class SessionController {
    const ID_USUARIO = "idUsuario";
    const NOME_USUARIO = "nomeUsuario";
    const INSTITUICOES = "instituicoes";
    const SESSION_NOT_STARTED = false;
    const SESSION_STARTED = true;
    
    private $sessionState = self::SESSION_NOT_STARTED;
    private static $instance;

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }

        self::$instance->startSession();

        return self::$instance;
    }

    public function getSessionState() {
        return $this->sessionState;
    }

    public function startSession() {
        if ($this->sessionState == self::SESSION_NOT_STARTED) {
            $this->sessionState = session_start();
        }

        return $this->sessionState;
    }

    public function createSession(Usuario $usuario) {
        if ($this->sessionState == self::SESSION_NOT_STARTED) {
            $this->startSession();
        }        
        $_SESSION[self::ID_USUARIO] = $usuario->getIdUsuario();
        $_SESSION[self::NOME_USUARIO] = $usuario->getNome();
        $_SESSION[self::INSTITUICOES] = $usuario->getInstituicoes();        
        return $this->sessionState;
    }

    public function hasSession($sessionName) {
        return $this->sessionState && isset($_SESSION[$sessionName]);
    }

    public function getSessionUser() {
        if ($this->sessionState) {
            $user = new Usuario();
            $user->setIdUsuario($_SESSION[self::ID_USUARIO]);
            $user->setNome($_SESSION[self::NOME_USUARIO]);
            $user->setInstituicoes($_SESSION[self::INSTITUICOES]);
            return $user;
        }
        return false;
    }

    public function closeSession() {
        if ($this->sessionState) {
            $this->sessionState = !session_destroy();
            unset($_SESSION);
            return !$this->sessionState;
        }
        return false;
    }
}