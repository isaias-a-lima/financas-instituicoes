<?php
namespace app\modules;

use app\lib\Constantes;

class LibModule {

    public function __construct()
    {
        require_once Constantes::DEFAULT_LIB_DIR . "/DateUtil.php";    
        require_once Constantes::DEFAULT_LIB_DIR . "/SecurityUtil.php";
        require_once Constantes::DEFAULT_LIB_DIR . "/StringUtil.php";
        require_once Constantes::DEFAULT_LIB_DIR . "/Validacoes.php";
    }
}