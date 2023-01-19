<?php

use app\controller\InstituicaoController;
use app\controller\SessionController;
use app\controller\RenderController;

$usuario = isset($usuario) ? $usuario : SessionController::getSessionUser();

$instituicaoController = new InstituicaoController();

?>
<section class="row">
    <div class="col-md-2">
        <h2>Instituições</h2>
    </div>
    <div class="col-md-10">
        <a href="./?p=<?= RenderController::PAGES['CADASTRO_INSTITUICAO']['cod'] ?>" title="Incluir" class="icones">
            <span class="glyphicon glyphicon-plus"></span>
        </a>
    </div>
</section>

<section class="row">
    <div class="col-md-12">
        <?php echo $instituicaoController->renderizeAllInstituicoes($usuario->getIdUsuario()); ?>
    </div>
</section>