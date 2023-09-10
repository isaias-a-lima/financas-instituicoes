<script src="./app/view/js/app.js"></script>
<?php

require "./app/lib/constantes.php";

use app\controller\SessionController;
use app\lib\Constantes;
require_once Constantes::DEFAULT_CONTROLLER_DIR . "/SessionController.php";
SessionController::getInstance();

include Constantes::DEFAULT_DIR . "/run.php";

?>
