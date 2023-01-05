<?php

use app\controller\ModuleController;
use app\lib\Constantes;

require_once Constantes::DEFAULT_CONTROLLER_DIR . "/ModuleController.php";
require_once Constantes::DEFAULT_LIB_DIR . "/SecurityUtil.php";
require_once Constantes::DEFAULT_EXCEPTIONS_DIR . "/ExceptionUtil.php";

new ModuleController();

include Constantes::DEFAULT_VIEW_DIR . "/header.php";
include Constantes::DEFAULT_VIEW_DIR . "/render.php";
include Constantes::DEFAULT_VIEW_DIR . "/footer.php";