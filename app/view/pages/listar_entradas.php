<?php

use app\controller\EntradaController;
use app\controller\RenderController;

$idInstituicao = isset($_GET['id']) ? $_GET['id'] : '';

$mkInicio = mktime(0,0,0,date("m"),1,date("Y"));
$mkFim = mktime(0, 0, 0, date("m"), date("t"), date("Y"));

$dataInicio = date("Y-m-d", $mkInicio);
$dataFim = date("Y-m-d", $mkFim);

$entradaController = new EntradaController();


?>

<?php include "./app/view/sessionInfo.php"; ?>

<ul class="pager">
    <li class="previous"><a href="./?p=<?= RenderController::PAGES['HOME']['cod'] ?>" class="btn btn-default">Voltar</a></li>    
</ul>

<h3>
    Entradas 
    <a href="./p=<?= RenderController::PAGES['CADASTRO_ENTRADA']['cod'] ?>" class="icones" title="Adicionar entradas" alt="Adicionar entradas"><span class="glyphicon glyphicon-plus"></span></a>
</h3>
Período: <?=$dataInicio?> - <?=$dataFim?>

<?php echo $entradaController->getByInstituicao($idInstituicao, $dataInicio, $dataFim); ?>