<?php

use app\controller\ControllerModule;
use app\lib\Constantes;

include Constantes::DEFAUL_CONTROLLER_DIR . "/ControllerModule.php";
new ControllerModule();

include Constantes::DEFAUL_VIEW_DIR . "/header.php";
include Constantes::DEFAUL_VIEW_DIR . "/body.php";
include Constantes::DEFAUL_VIEW_DIR . "/footer.php";