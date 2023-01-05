<?php

use app\controller\RenderController;
use app\lib\Constantes;
use app\lib\SecurityUtil;

$page = 0;

if (isset($_POST['p'])) {
    $page = SecurityUtil::sanitizeInteger($_POST['p']);
}

if (isset($_GET['p'])) {
    $page = SecurityUtil::sanitizeInteger($_GET['p']);
}

include Constantes::DEFAULT_VIEW_DIR . "/pages" . RenderController::rendering($page);

?>