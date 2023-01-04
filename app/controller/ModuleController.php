<?php
namespace app\controller;

use app\lib\Constantes;

class ModuleController {
    public function __construct() {
        require_once Constantes::DEFAULT_CONTROLLER_DIR . "/UsuarioController.php";
        require_once Constantes::DEFAULT_CONTROLLER_DIR . "/SessionController.php";
        require_once Constantes::DEFAULT_CONTROLLER_DIR . "/RenderController.php";
    }
}