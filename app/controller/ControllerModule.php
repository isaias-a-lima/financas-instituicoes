<?php
namespace app\controller;

use app\lib\Constantes;

class ControllerModule {
    public function __construct() {
        require_once Constantes::DEFAUL_CONTROLLER_DIR . "/UsuarioController.php";
        require_once Constantes::DEFAUL_CONTROLLER_DIR . "/SessaoController.php";
    }
}