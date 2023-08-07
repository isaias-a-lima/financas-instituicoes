<?php

use app\lib\Constantes;
use app\modules\Modules;

require_once Constantes::DEFAULT_MODULES_DIR . "/Modules.php";
require_once Constantes::DEFAULT_LIB_DIR . "/SecurityUtil.php";
require_once Constantes::DEFAULT_EXCEPTIONS_DIR . "/ExceptionUtil.php";

new Modules();

include Constantes::DEFAULT_VIEW_DIR . "/header.php";
include Constantes::DEFAULT_VIEW_DIR . "/render.php";
include Constantes::DEFAULT_VIEW_DIR . "/footer.php";