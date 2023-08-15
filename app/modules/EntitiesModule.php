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
        require_once Constantes::DEFAULT_MODEL_DIR . "/entities/Entrada.php";
        require_once Constantes::DEFAULT_MODEL_DIR . "/entities/converter/EntradaConverter.php";
        require_once Constantes::DEFAULT_MODEL_DIR . "/entities/Categoria.php";
        require_once Constantes::DEFAULT_MODEL_DIR . "/entities/converter/CategoriaConverter.php";
        require_once Constantes::DEFAULT_MODEL_DIR . "/entities/Mensagem.php";
        require_once Constantes::DEFAULT_MODEL_DIR . "/entities/converter/BooleanConverter.php";
    }
}