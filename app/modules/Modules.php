<?php
namespace app\modules;

use app\lib\Constantes;

require_once Constantes::DEFAULT_MODULES_DIR . "/ControllerModule.php";
require_once Constantes::DEFAULT_MODULES_DIR . "/DaoModule.php";
require_once Constantes::DEFAULT_MODULES_DIR . "/EntitiesModule.php";
require_once Constantes::DEFAULT_MODULES_DIR . "/LibModule.php";

class Modules {

    public function __construct() {
        new LibModule();
        new EntitiesModule();
        new DaoModule();
        new ControllerModule();
    }
}