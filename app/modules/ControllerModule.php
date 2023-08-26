<?php
namespace app\modules;

use app\lib\Constantes;

class ControllerModule {
    public function __construct() {
        require_once Constantes::DEFAULT_CONTROLLER_DIR . "/UsuarioController.php";        
        require_once Constantes::DEFAULT_CONTROLLER_DIR . "/RenderController.php";
        require_once Constantes::DEFAULT_CONTROLLER_DIR . "/LoginController.php";
        require_once Constantes::DEFAULT_CONTROLLER_DIR . "/InstituicaoController.php";
        require_once Constantes::DEFAULT_CONTROLLER_DIR . "/EntradaController.php";
        require_once Constantes::DEFAULT_CONTROLLER_DIR . "/CategoriaController.php";
        require_once Constantes::DEFAULT_CONTROLLER_DIR . "/FechamentoController.php";
    }
}