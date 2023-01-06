<?php

use app\controller\RenderController;
use app\lib\Constantes;
use app\lib\SecurityUtil;

$codPage = 0;

if (isset($_POST['p'])) {
    $codPage = SecurityUtil::sanitizeInteger($_POST['p']);
}

if (isset($_GET['p'])) {
    $codPage = SecurityUtil::sanitizeInteger($_GET['p']);
}

include Constantes::DEFAULT_VIEW_DIR . "/pages" . RenderController::rendering($codPage);

?>