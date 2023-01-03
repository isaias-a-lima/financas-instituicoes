<?php

use app\controller\ModuleController;
use app\lib\Constantes;

include Constantes::DEFAULT_CONTROLLER_DIR . "/ModuleController.php";
new ModuleController();

include Constantes::DEFAULT_VIEW_DIR . "/header.php";
include Constantes::DEFAULT_VIEW_DIR . "/body.php";
include Constantes::DEFAULT_VIEW_DIR . "/footer.php";