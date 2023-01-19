<?php
namespace app\modules;

use app\lib\Constantes;

class EntitiesModule {

    public function __construct() {
        require_once Constantes::DEFAULT_MODEL_DIR . "/entities/converter/ConverterInterface.php";
        require_once Constantes::DEFAULT_MODEL_DIR . "/entities/Usuario.php";
        require_once Constantes::DEFAULT_MODEL_DIR . "/entities/converter/UsuarioConverter.php";
        require_once Constantes::DEFAULT_MODEL_DIR . "/entities/Instituicao.php";
        require_once Constantes::DEFAULT_MODEL_DIR . "/entities/converter/InstituicaoConverter.php";
    }
}