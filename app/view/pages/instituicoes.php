<?php

use app\controller\InstituicaoController;
use app\controller\SessionController;
use app\controller\RenderController;

$sessao = SessionController::getInstance();

$usuario = isset($usuario) ? $usuario : $sessao->getSessionUser();

$instituicaoController = new InstituicaoController();

?>
<section class="row">
    <div class="col-md-12">
        <h2>
            Instituições
            <a href="./?p=<?= RenderController::PAGES['CADASTRO_INSTITUICAO']['cod'] ?>" 
                title="Incluir nova instituição" 
                alt="Incluir nova instituição" 
                class="icones">
                <span class="glyphicon glyphicon-plus"></span>
            </a>
        </h2>
    </div>
</section>

<section class="row">
    <div class="col-md-12">
        <?php echo $instituicaoController->renderizeAllInstituicoes($usuario->getIdUsuario()); ?>
    </div>
</section>