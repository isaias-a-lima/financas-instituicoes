<?php

use app\controller\SaidaController;
use app\controller\InstituicaoController;
use app\controller\RenderController;

$p = isset($_GET['p']) ? $_GET['p'] : '2';
$idInstituicao = isset($_GET['idi']) ? $_GET['idi'] : '';

$mkInicio = mktime(0, 0, 0, date("m"), 1, date("Y"));
$mkFim = mktime(0, 0, 0, date("m"), date("t"), date("Y"));

$dataInicio = isset($_GET['dataInicio']) ? $_GET['dataInicio'] : date("Y-m-d", $mkInicio);
$dataFim = isset($_GET['dataFim']) ? $_GET['dataFim'] : date("Y-m-d", $mkFim);

$instituicaoController = new InstituicaoController();

$instituicao = $instituicaoController->getById($idInstituicao);

$saidaController = new SaidaController();


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
            <li class="active">Saídas</li>
        </ol>
    </div>
</section>

<h2><?= $instituicao->getNome() ?></h2>

<section class="row">
    <div class="col-md-6 espaco-padrao">
        <div class="input-group">
            <input type="hidden" id="idi" value="<?= $idInstituicao ?>" />
            <input type="hidden" id="p" value="<?= $p ?>" />
            <input class="form-control" type="date" id="dataInicio" style="width: 50%;" value="<?= $dataInicio ?>" />
            <input class="form-control" type="date" id="dataFim" style="width: 50%;" value="<?= $dataFim ?>" />
            <div class="input-group-btn">
                <button id="btn-periodo" class="btn btn-default"><i class="glyphicon glyphicon-search"></i></button>
            </div>
        </div>
    </div>    
</section>

<section class="row">
    <div class="col-md-6">
        <h3>Saídas</h3>
    </div>

    <div class="col-md-6 text-right espaco-padrao">
        <a href="./?p=<?= RenderController::PAGES['CADASTRO_SAIDA']['cod'] ?>&idi=<?= $idInstituicao ?>" class="btn btn-info" title="Adicionar saidas" alt="Adicionar saidas">
            <span class="glyphicon glyphicon-plus"></span> Adicionar Saída
        </a>
    </div>
</section>

<section class="row">
    <div class="col-md-12">
        <?php echo $saidaController->getByInstituicao($idInstituicao, $dataInicio, $dataFim, true); ?>
    </div>
</section>
<script src="./app/view/js/listar_saidas.js"></script>