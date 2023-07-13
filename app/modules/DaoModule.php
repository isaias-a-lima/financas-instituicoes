<?php
namespace app\modules;

use app\lib\Constantes;

class DaoModule {

    public function __construct() {
        require_once Constantes::DEFAULT_MODEL_DIR . "/dao/Conexao.php";
        require_once Constantes::DEFAULT_MODEL_DIR . "/dao/patterns/DaoPattern.php";
        require_once Constantes::DEFAULT_MODEL_DIR . "/dao/LoginDao.php";
        require_once Constantes::DEFAULT_MODEL_DIR . "/dao/UsuarioDao.php";
        require_once Constantes::DEFAULT_MODEL_DIR . "/dao/sql/SqlBuilder.php";
        require_once Constantes::DEFAULT_MODEL_DIR . "/dao/sql/Query.php";
        require_once Constantes::DEFAULT_MODEL_DIR . "/dao/sql/SqlConsts.php";
        require_once Constantes::DEFAULT_MODEL_DIR . "/dao/InstituicaoDao.php";
        require_once Constantes::DEFAULT_MODEL_DIR . "/dao/EntradaDao.php";
    }
}