<?php

use app\controller\EntradaController;
use app\controller\FechamentoController;
use app\controller\RenderController;
use app\controller\SaidaController;

$p = isset($_GET['p']) ? $_GET['p'] : '2';
$idFechamento = isset($_GET['idf']) ? $_GET['idf'] : '';
$idInstituicao = isset($_GET['idi']) ? $_GET['idi'] : '';
$htmlToPDF = "";

$fechamentoController = new FechamentoController();
$entradaController = new EntradaController();
$saidaController = new SaidaController();

$fechamento = $fechamentoController->getById($idFechamento);

$nomeInstituicao = $fechamento->getInstituicao()->getNome();
$cnpjInstituicao = $fechamento->getInstituicao()->getCnpj();

$saldoInicial = $fechamento->getSaldoInicial();
$saldoInicialFormatado = number_format($saldoInicial, 2, ",", ".");
$entradas = $fechamento->getEntradas();
$entradasFormatado = number_format($entradas, 2, ",", ".");
$saidas = $fechamento->getSaidas();
$saidasFormatado = number_format($saidas, 2, ",", ".");
$fluxoCaixa = $entradas - $saidas;
$fluxoCaixaFormatado = number_format($fluxoCaixa, 2, ",", ".");
$saldoFinal = $saldoInicial - $fluxoCaixa;
$saldoFinalFormatado = number_format($saldoFinal, 2, ",", ".");

$mesFechamento = DateUtil::getMonth(intval(date("m", strtotime($fechamento->getDataInicio()))));
$anoFechamento = date("Y", strtotime($fechamento->getDataInicio()));

//Grafico
//Calculos para o gráfico
//Qual o maior valor
$maiorValorGrafico = $saldoInicial > $entradas ? $saldoInicial : $entradas;
$maiorValorGrafico = $maiorValorGrafico > $saidas ? $maiorValorGrafico : $saidas;
$maiorValorGrafico = $maiorValorGrafico > $fluxoCaixa ? $maiorValorGrafico : $fluxoCaixa;
$maiorValorGrafico = $maiorValorGrafico > $saldoFinal ? $maiorValorGrafico : $saldoFinal;

//Calculo de percentuais para definir tamanho das barras do gráfico
$saldoInicialGrafico = $saldoInicial > 0 ? round($saldoInicial / $maiorValorGrafico * 100, 0) : 0;
$entradasGrafico = $entradas > 0 ? round($entradas / $maiorValorGrafico * 100, 0) : 0;
$saidasGrafico = $saidas > 0 ? round($saidas / $maiorValorGrafico * 100, 0) : 0;
$fluxoCaixaGrafico = $fluxoCaixa > 0 ? round($fluxoCaixa / $maiorValorGrafico * 100, 0) : 0;
$saldoFinalGrafico = $saldoFinal > 0 ? round($saldoFinal / $maiorValorGrafico * 100, 0) : 0;

//Entradas
$htmlEntradas = $entradaController->getByInstituicao($idInstituicao, $fechamento->getDataInicio(), $fechamento->getDataFim(), false);
$htmlEntradasPDF = $entradaController->getByInstituicaoForPDF($idInstituicao, $fechamento->getDataInicio(), $fechamento->getDataFim());
//Saidas
$htmlSaidas = $saidaController->getByInstituicao($idInstituicao, $fechamento->getDataInicio(), $fechamento->getDataFim(), false);
$htmlSaidasPDF = $saidaController->getByInstituicaoForPDF($idInstituicao, $fechamento->getDataInicio(), $fechamento->getDataFim());

//Define nome do PDF
$rest = $nomeInstituicao;
$pdfName = "";
$countWords = (int) str_word_count($nomeInstituicao);
while ($countWords > 0) {
    $str = substr($rest, 0, strpos($rest, " "));
    $pdfName .= strtoupper(substr($rest, 0, 1));
    $rest = substr($rest, strpos($rest, " ")+1);
    $countWords--;    
}
$pdfName .= '_Fechamento_Mensal_' . $mesFechamento .'_' . $anoFechamento . '.pdf';

//Define o conteudo do PDF
$htmlToPDF .= "
<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <title>Fechamento Mensal - $mesFechamento/$anoFechamento</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10pt;
        }

        .pdf-table {
            width: 100%;
            border-collapse: collapse;	
        }
        
        .pdf-table th {
            background-color: #ccc;
            border: 1px solid #000;
            padding: 2px 5px;
        }
        
        .pdf-table td {
            border: 1px solid #000;
            padding: 2px 5px;
        }

        .pdf-grafico {
            width: 100%;	
        }

        .pdf-grafico th {
            background-color: #ccc;
            padding: 2px 5px;
            text-align: right;
        }
        
        .pdf-grafico td {
            padding: 2px 5px;
        }

        .td-grafico {
            border: 1px solid #ccc;
            text-align: right;
        }

        .barra-g1 {
            background-color: #0080c9;
            width: $saldoInicialGrafico%;
        }
        .barra-g2 {
            background-color: #7dccff;
            width: $entradasGrafico%;
        }
        .barra-g3 {
            background-color: #ce2a20;
            width: $saidasGrafico%;
        }
        .barra-g4 {
            background-color: #fbc344;
            width: $fluxoCaixaGrafico%;
        }
        .barra-g5 {
            background-color: #34b666;
            width: $saldoFinalGrafico%;
        }
    </style>
</head>
<body>
    <header>
        <h1>Fechamento Mensal - $mesFechamento/$anoFechamento</h1>
        <h2>$nomeInstituicao</h2>
        <p>
            <strong>CNPJ:</strong> $cnpjInstituicao
        </p>
    </header>

    <section>
        <h3>Gráfico</h3>
        <table class='pdf-grafico'>            
            <tr><th style='width:100px;'>Saldo Inicial</th><td class='td-grafico' style='width:100px;'>$saldoInicialFormatado</td><td><div class='barra-g1'>&nbsp;</div></td></tr>
            <tr><th>Entradas</th><td class='td-grafico'>$entradasFormatado</td><td><div class='barra-g2'>&nbsp;</div></td></tr>
            <tr><th>Saídas</th><td class='td-grafico'>$saidasFormatado</td><td><div class='barra-g3'>&nbsp;</div></td></tr>
            <tr><th>Fluxo de Caixa</th><td class='td-grafico'>$fluxoCaixaFormatado</td><td><div class='barra-g4'>&nbsp;</div></td></tr>
            <tr><th>Saldo Final</th><td class='td-grafico'>$saldoFinalFormatado</td><td><div class='barra-g5'>&nbsp;</div></td></tr>
        </table>
    </section>
    
    <section>
        <h3>Entradas</h3>
        $htmlEntradasPDF
    </section>
    
    <section>
        <h3>Saídas</h3>
        $htmlSaidasPDF
    </section>

";

$htmlToPDF .= "
    </body>
</html>
";
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
                <a href="./?p=<?= RenderController::PAGES['DASHBOARD_INSTITUICAO']['cod'] ?>&idi=<?= $idInstituicao ?>">
                    Painel
                </a>
            </li>
            <li>
                <a href="./?p=<?= RenderController::PAGES['LISTAR_FECHAMENTOS']['cod'] ?>&idi=<?= $idInstituicao ?>">
                    Fechamentos
                </a>
            </li>
            <li class="active"><?= $mesFechamento ?>-<?= $anoFechamento ?></li>
        </ol>
    </div>
</section>

<h2><?= $fechamento->getInstituicao()->getNome() ?></h2>

<section class="row">
    <div class="col-md-6">
        <h3>Fechamento Mensal - <?= $mesFechamento ?>/<?= $anoFechamento ?></h3>
    </div>

    <div class="col-md-6 text-right espaco-padrao">
        <span class="tools glyphicon glyphicon-file" title="PDF" alt="PDF" id="btn-gerar-pdf"></span>
        <span class="tools glyphicon glyphicon-send" title="Enviar ao contador" alt="Enviar ao contador"></span>
        &nbsp;
        &nbsp;
    </div>
</section>

<h3>Gráfico</h3>

<section class="row">
    <div class="col-md-6">
        
        <table><tr><td style="width: 100px;"><span class="small">Saldo Inicial: </span></td><td><span id="saldoInicialBarra"><?= "R$ " . number_format($saldoInicial, 2, ",", ".") ?></span></td></tr></table>
        <div class="progress">
            <div id="saldoInicialBarra2" class="progress-bar" role="progressbar" aria-valuenow="<?= $saldoInicialGrafico ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?= $saldoInicialGrafico ?>%">
                &nbsp;
            </div>
        </div>
        
        <table><tr><td style="width: 100px;"><span class="small">Entradas: </span></td><td><span id="entradasBarra"><?= "R$ " . number_format($entradas, 2, ",", ".") ?></span></td></tr></table>
        <div class="progress">
            <div id="entradasBarra2" class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="<?= $entradasGrafico ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?= $entradasGrafico ?>%">
                &nbsp;
            </div>
        </div>
         
        <table><tr><td style="width: 100px;"><span class="small">Saídas: </span></td><td><span id="saidasBarra"><?= "R$ " . number_format($saidas, 2, ",", ".") ?></span></td></tr></table>
        <div class="progress">
            <div id="saidasBarra2" class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="<?= $saidasGrafico ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?= $saidasGrafico ?>%">
                &nbsp;
            </div>
        </div>

        <table><tr><td style="width: 100px;"><span class="small">Fluxo de Caixa: </span></td><td><span id="fluxoCaixaBarra"><?= "R$ " . number_format($fluxoCaixa, 2, ",", ".") ?></span></td></tr></table>
        <div class="progress">
            <div id="fluxoCaixaBarra2" class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="<?= $fluxoCaixaGrafico ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?= $fluxoCaixaGrafico ?>%">
                &nbsp;
            </div>
        </div>
         
        <table><tr><td style="width: 100px;"><span class="small">Saldo Final: </span></td><td><span id="saldoFinalBarra"><?= "R$ " . number_format($saldoFinal, 2, ",", ".") ?></span></td></tr></table>
        <div class="progress">
            <div id="saldoFinalBarra2" class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?= $saldoFinalGrafico ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?= $saldoFinalGrafico ?>%">
                &nbsp;
            </div>
        </div>

    </div>
</section>

<h3>Entradas</h3>

<section class="row">
    <div class="col-md-12">
        <?= $htmlEntradas ?>
    </div>
</section>

<h3>Saídas</h3>

<section class="row">
    <div class="col-md-12">
        <?= $htmlSaidas ?>
    </div>
</section>

<form id="form-pdf" method="post" action="./app/view/pages/pdf.php" target="_new">
    <input type="hidden" name="html-to-pdf" value="<?=$htmlToPDF?>">
    <input type="hidden" name="file-name" value="<?=$pdfName?>">
</form>

<script src="./app/view/js/ver_fechamento.js"></script>