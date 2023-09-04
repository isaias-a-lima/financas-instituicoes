<?php

use app\controller\FechamentoController;
use app\controller\InstituicaoController;
use app\controller\RenderController;

$p = isset($_GET['p']) ? $_GET['p'] : '2';
$idInstituicao = isset($_GET['idi']) ? $_GET['idi'] : '';

$ano = isset($_GET['ano']) ? $_GET['ano'] : date("Y");
$anoAtual = (int) date("Y");
$mesAtual = (int) date("m");

$instituicaoController = new InstituicaoController();

$instituicao = $instituicaoController->getById($idInstituicao);

$fechamentoController = new FechamentoController();

$dataFechamento = date("Y-m-d", mktime(0, 0, 0, ($mesAtual-1), 1, $anoAtual));
$hasFechamento = $fechamentoController->hasFechamento($idInstituicao, $dataFechamento);
$btnDisabledStyle = $hasFechamento ? "disabled" : "";


?>

<?php include "./app/view/sessionInfo.php"; ?>

<section class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">
            <li>
                <a href="./?p=<?= RenderController::PAGES['HOME']['cod'] ?>">
                    <span class="glyphicon glyphicon-arrow-left"></span> Home
                </a>
            </li>
            <li>
                <a href="./?p=<?= RenderController::PAGES['LISTAR_INSTITUICOES']['cod'] ?>">Instituições</a>
            </li>
            <li>
                <a href="./?p=<?= RenderController::PAGES['DASHBOARD_INSTITUICAO']['cod'] ?>&idi=<?=$idInstituicao?>">
                    Painel
                </a>
            </li>
            <li class="active">Fechamentos</li>
        </ol>
    </div>
</section>

<h2><?= $instituicao->getNome() ?></h2>

<section class="row">
    <div class="col-md-2 espaco-padrao">
        <input type="hidden" id="idi" value="<?= $idInstituicao ?>" />
        <input type="hidden" id="p" value="<?= $p ?>" />

        <div class="input-group">            
            <input class="form-control" type="number" id="ano" min="2023" max="9999" step="1" value="<?= $ano ?>" />
            <div class="input-group-btn">
                <button id="btn-periodo" class="btn btn-default"><i class="glyphicon glyphicon-search"></i></button>
            </div>
        </div>
    </div>    
</section>

<section class="row">
    <div class="col-md-6">
        <h3>Fechamentos</h3>
    </div>

    <div class="col-md-6 text-right espaco-padrao">
        <a href="./?p=<?= RenderController::PAGES['CADASTRO_FECHAMENTO']['cod'] ?>&idi=<?= $idInstituicao ?>" class="btn btn-info <?=$btnDisabledStyle?>" title="Adicionar fechamentos" alt="Adicionar fechamentos">
            <span class="glyphicon glyphicon-plus"></span> Adicionar Fechamento
        </a>
    </div>
</section>

<section class="row">
    <div class="col-md-12">
        <?php echo $fechamentoController->getByInstituicao($idInstituicao, $ano); ?>
    </div>
</section>
<script src="./app/view/js/listar_fechamentos.js"></script>