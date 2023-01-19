<?php

use app\controller\InstituicaoController;
use app\controller\SessionController;

$usuario = isset($usuario) ? $usuario : SessionController::getSessionUser();

$instituicaoController = new InstituicaoController();

echo $instituicaoController->renderizeAllInstituicoes($usuario->getIdUsuario());
?>