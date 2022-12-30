<?php
namespace app\controller;

use app\lib\Constantes;

class ControllerModule {
    public function __construct() {
        require_once Constantes::DEFAULT_DIR . "/controller/UsuarioController.php";
    }
}