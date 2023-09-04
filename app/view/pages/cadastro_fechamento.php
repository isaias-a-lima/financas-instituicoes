<?php

use app\controller\EntradaController;
use app\controller\FechamentoController;
use app\controller\InstituicaoController;
use app\controller\RenderController;
use app\controller\SaidaController;
use app\lib\Constantes;
use app\model\entities\Fechamento;
use app\model\entities\Instituicao;

$msg = "";
$msgError = "";
const FECHAMENTO = "F";
$disabledStyle = "";
$p = isset($_GET['p']) ? $_GET['p'] : 0;

$hasFechamento = false;
$fechamento = null;
$fechamentoAnterior = null;
$saldoInicial = $entradas = $saidas = $fluxoCaixa = $saldoFinal = 0.0;
$saldoInicialGrafico = $entradasGrafico = $saidasGrafico = $fluxoCaixaGrafico = $saldoFinalGrafico = 0.0;

$fechamentoController = new FechamentoController();

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $instituicao = new Instituicao();
        $instituicao->setIdInstituicao($_POST['idInstituicao']);
        $instituicao->setNome($_POST['nomeInstituicao']);
        
        $fechamento = new Fechamento();
        $fechamento->setInstituicao($instituicao);
        $fechamento->setDataInicio($_POST['dataInicio']);
        $fechamento->setDataFim($_POST['dataFim']);
        $fechamento->setSaldoInicial($_POST['saldoInicial']);
        $fechamento->setEntradas($_POST['entradas']);
        $fechamento->setSaidas($_POST['saidas']);

        $disabledStyle = "disabled";

        $fechamentoController->saveFechamento($fechamento);        
    }
} catch (Exception $e) {
    $msg = $e->getMessage();
    $msgError = "<div class='alert alert-danger'>$msg</div>";
}

try {
    
    $ano = isset($_GET['ano']) ? $_GET['ano'] : date("Y");
    $mes = isset($_GET['mes']) ? $_GET['mes'] : date("m") - 1;

    $dataInicio = date("Y-m-d", mktime(0, 0, 0, $mes, 1, $ano));
    $dataFim = date("Y-m-t", mktime(0, 0, 0, $mes, 1, $ano));

    $idInstituicao = isset($_GET['idi']) ? $_GET['idi'] : "";

    $instituicaoController = new InstituicaoController();
    $instituicao = $instituicaoController->getById($idInstituicao);

    $fechamentoAnterior = $fechamentoController->getFechamentoAnterior($idInstituicao, $dataInicio);

    if (!is_bool($fechamentoAnterior)) {
        $saldoInicial = $fechamentoAnterior->getSaldoInicial() + $fechamentoAnterior->getEntradas() - $fechamentoAnterior->getSaidas();
    }

    $entradaController = new EntradaController();
    $result = $entradaController->getSomaById($idInstituicao, $dataInicio, $dataFim);
    $entradas = isset($result) && !is_bool($result) ? (float) $result : $entradas;

    $result = null;

    $saidaController = new SaidaController();
    $result = $saidaController->getSomaById($idInstituicao, $dataInicio, $dataFim);
    $saidas = isset($result) && !is_bool($result) ? (float) $result : $saidas;

    $fluxoCaixa = $entradas - $saidas;
    $saldoFinal = $saldoInicial + $entradas - $saidas;

    //Calculos para o gráfico
    $maiorValorGrafico = $saldoInicial > $entradas ? $saldoInicial : $entradas;
    $maiorValorGrafico = $maiorValorGrafico > $saidas ? $maiorValorGrafico : $saidas;
    $maiorValorGrafico = $maiorValorGrafico > $fluxoCaixa ? $maiorValorGrafico : $fluxoCaixa;
    $maiorValorGrafico = $maiorValorGrafico > $saldoFinal ? $maiorValorGrafico : $saldoFinal;

    $saldoInicialGrafico = $saldoInicial > 0 ? round($saldoInicial / $maiorValorGrafico * 100, 0) : 0;
    $entradasGrafico = $entradas > 0 ? round($entradas / $maiorValorGrafico * 100, 0) : 0;
    $saidasGrafico = $saidas > 0 ? round($saidas / $maiorValorGrafico * 100, 0) : 0;
    $fluxoCaixaGrafico = $fluxoCaixa > 0 ? round($fluxoCaixa / $maiorValorGrafico * 100, 0) : 0;
    $saldoFinalGrafico = $saldoFinal > 0 ? round($saldoFinal / $maiorValorGrafico * 100, 0) : 0;
    
} catch (Exception $e) {
    $msg = $e->getMessage();
    $msgError = "<div class='alert alert-danger'>$msg</div>";
}

include "./app/view/sessionInfo.php";

?>

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
                <a href="./?p=<?= RenderController::PAGES['DASHBOARD_INSTITUICAO']['cod'] ?>&idi=<?= $idInstituicao ?>">
                    Painel
                </a>
            </li>
            <li>
                <a href="./?p=<?= RenderController::PAGES['LISTAR_FECHAMENTOS']['cod'] ?>&idi=<?= $idInstituicao ?>">
                    Fechamentos
                </a>
            </li>
            <li class="active">Registrar Fechamento</li>
        </ol>
    </div>
</section>

<h2><?= $instituicao->getNome() ?></h2>

<section class="row">
    <div class="col-md-12">
        <h3>Registrar Fechamento</h3>
        <?= $msgError ?>
    </div>
</section>

<form method="post" action="<?php $_SERVER['PHP_SELF'] ?>">

    <section class="row">
        <div class="col-md-6">
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="ano">Ano</label>
                    <input class="form-control" type="number" name="ano" id="ano" value="<?= $ano ?>" readonly required />
                </div>
                <div class="col-md-6">
                    <label for="mes">Mês</label>
                    <select name="mes" id="mes" class="form-control">
                        <option value="<?= $mes ?>"><?= Constantes::MES[$mes] ?></option>
                        <?php
                        foreach (Constantes::MES as $i => $value) {
                            if (isset($mes) && $i == 0) {
                                continue;
                            }
                            echo '<option value="' . $i . '">' . $value . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
    </section>

    <input type="hidden" name="p" id="p" value="<?=$p?>" required />
    <input type="hidden" name="idInstituicao" id="idInstituicao" value="<?=$instituicao->getIdInstituicao()?>" required />
    <input type="hidden" name="nomeInstituicao" id="nomeInstituicao" value="<?=$instituicao->getNome()?>" required />
    <input type="hidden" name="dataInicio" id="dataInicio" value="<?=$dataInicio?>" required />
    <input type="hidden" name="dataFim" id="dataFim" value="<?=$dataFim?>" required />
    <input type="hidden" name="saldoInicial" id="saldoInicial" value="<?= $saldoInicial ?>" required />
    <input type="hidden" name="entradas" id="entradas" value="<?= $entradas ?>" required />
    <input type="hidden" name="saidas" id="saidas" value="<?= $saidas ?>" required />
    <input type="hidden" name="saldoFinal" id="saldoFinal" value="<?= $saldoFinal ?>" required />

    <section class="row">
        <div class="col-md-6">
            <span class="small">Saldo Inicial: </span><?= "R$ " . number_format($saldoInicial, 2, ",", ".") ?>
            <div class="progress">
                <div class="progress-bar" role="progressbar" aria-valuenow="<?= $saldoInicialGrafico ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?= $saldoInicialGrafico ?>%">
                    &nbsp;
                </div>
            </div>

            <span class="small">Entradas: </span> <?= "R$ " . number_format($entradas, 2, ",", ".") ?>
            <div class="progress">
                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="<?= $entradasGrafico ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?= $entradasGrafico ?>%">
                    &nbsp;
                </div>
            </div>

            <span class="small">Saídas: </span> <?= "R$ " . number_format($saidas, 2, ",", ".") ?>
            <div class="progress">
                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="<?= $saidasGrafico ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?= $saidasGrafico ?>%">
                    &nbsp;
                </div>
            </div>

            <span class="small">Fluxo de Caixa: </span> <?= "R$ " . number_format($fluxoCaixa, 2, ",", ".") ?>
            <div class="progress">
                <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="<?= $fluxoCaixaGrafico ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?= $fluxoCaixaGrafico ?>%">
                    &nbsp;
                </div>
            </div>

            <span class="small">Saldo Final: </span><?= "R$ " . number_format($saldoFinal, 2, ",", ".") ?>
            <div class="progress">
                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?= $saldoFinalGrafico ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?= $saldoFinalGrafico ?>%">
                    &nbsp;
                </div>
            </div>

        </div>
    </section>

    <section class="row">
        <div class="col-md-6">
            <input class="btn btn-primary" type="submit" value="Salvar" <?=$disabledStyle?> />
        </div>
    </section>

</form>
<script src="./app/view/js/cadastro_fechamento.js"></script>