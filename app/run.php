<?php

use app\controller\ControllerModule;
use app\lib\Constantes;

include Constantes::DEFAUL_CONTROLLER_DIR . "/ControllerModule.php";
new ControllerModule();

include Constantes::DEFAUL_VIEW_TDIR . "/header.php";
include Constantes::DEFAUL_VIEW_TDIR . "/body.php";
include Constantes::DEFAUL_VIEW_TDIR . "/footer.php";