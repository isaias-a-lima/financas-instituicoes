<?php

use app\controller\InstituicaoController;
use app\controller\SessionController;
use app\controller\RenderController;

$sessao = SessionController::getInstance();

$usuario = isset($usuario) ? $usuario : $sessao->getSessionUser();

$instituicaoController = new InstituicaoController();

?>

<?php include "./app/view/sessionInfo.php"; ?>

<section class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">
            <li>
                <a href="./?p=<?= RenderController::PAGES['HOME']['cod'] ?>">
                    <i class="glyphicon glyphicon-arrow-left"></i>
                    Home
                </a>
            </li>
            <li class="active">Instituições</li>
        </ol>
    </div>
</section>

<section class="row">
    <div class="col-md-3 espaco-padrao">
        <h3>Instituições</h3>
    </div>

    <div class="col-md-9 text-right espaco-padrao">
        <a href="./?p=<?= RenderController::PAGES['CADASTRO_INSTITUICAO']['cod'] ?>" class="btn btn-info" title="Incluir nova instituição" alt="Incluir nova instituição">
            <span class="glyphicon glyphicon-plus"></span> Adicionar Instituição
        </a>
    </div>
</section>

<section class="row">
    <div class="col-md-12">
        <?php echo $instituicaoController->renderizeAllInstituicoes($usuario->getIdUsuario()); ?>
    </div>
</section>