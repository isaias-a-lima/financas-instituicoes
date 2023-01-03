<?php

use app\controller\ControllerModule;
use app\lib\Constantes;

include Constantes::DEFAULT_CONTROLLER_DIR . "/ControllerModule.php";
new ControllerModule();

include Constantes::DEFAULT_VIEW_DIR . "/header.php";
include Constantes::DEFAULT_VIEW_DIR . "/body.php";
include Constantes::DEFAULT_VIEW_DIR . "/footer.php";