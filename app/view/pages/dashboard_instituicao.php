<?php

use app\controller\InstituicaoController;
use app\controller\RenderController;

include "./app/view/sessionInfo.php";

$linkEntradas = RenderController::PAGES['LISTAR_ENTRADAS']['cod'];
$linkSaidas = RenderController::PAGES['LISTAR_SAIDAS']['cod'];
$linkFechamentos = RenderController::PAGES['LISTAR_FECHAMENTOS']['cod'];
$linkContas = RenderController::PAGES['LISTAR_CONTAS']['cod'];
$linkEditar = RenderController::PAGES['EDITAR_INSTITUICAO']['cod'];
$linkFaturas = RenderController::PAGES['LISTAR_FATURAS']['cod'];
$linkPermitirUser = RenderController::PAGES['PERMITIR_USUARIO']['cod'];
$linkUsuariosInstituicoes = RenderController::PAGES['USUARIOS_INSTITUICOES']['cod'];

$idInstituicao = isset($_GET['idi']) ? $_GET['idi'] : '';

$instituicaoController = new InstituicaoController();

$instituicao = $instituicaoController->getById($idInstituicao);

$isTitular = $usuario->getIdUsuario() == $instituicao->getTitular()->getIdUsuario();
$cssDisplay = $isTitular ? "block" : "none";

$infoEditar = "Editar dados da instituição";
$infoAddUser = "Permitir acesso de usuário à instituição";
?>

<section class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">
            <li>
                <a href="./?p=<?= RenderController::PAGES['HOME']['cod'] ?>">
                    <i class="glyphicon glyphicon-arrow-left"></i>
                    Home
                </a>
            </li>
            <li><a href="./?p=<?= RenderController::PAGES['LISTAR_INSTITUICOES']['cod'] ?>">Instituições</a></li>
            <li class="active">Painel</li>
        </ol>
    </div>
</section>

<h2><?=$instituicao->getNome()?></h2>

<section class="row">
    <div class="col-md-3 espaco-padrao">
        <div class="menu" onclick="document.location.href='./?p=<?=$linkEntradas?>&idi=<?=$idInstituicao?>'">
            <i class="glyphicon glyphicon-plus-sign text-primary"></i>
            &nbsp;
            Entradas
        </div>
    </div>

    <div class="col-md-3 espaco-padrao">
        <div class="menu" onclick="document.location.href='./?p=<?=$linkSaidas?>&idi=<?=$idInstituicao?>'">
            <i class="glyphicon glyphicon-minus-sign text-danger"></i>
            &nbsp;
            Saídas
        </div>
    </div>

    <div class="col-md-3 espaco-padrao">
        <div class="menu" onclick="document.location.href='./?p=<?=$linkFechamentos?>&idi=<?=$idInstituicao?>'">
            <i class="glyphicon glyphicon-stats text-success"></i>
            &nbsp;
            Fechamentos
        </div>
    </div>
    <?php
    //Oculta botões caso não seja o titular
    if ($isTitular) {    
    ?>
    <div class="col-md-3 espaco-padrao" style="display: none;">
        <div class="menu" onclick="">
            <i class="glyphicon glyphicon-usd text-warning"></i>
            &nbsp;
            Contas
        </div>
    </div>

    <div class="col-md-3 espaco-padrao" style="display: none;">
        <div class="menu" onclick="">
            <i class="glyphicon glyphicon-cog"></i>
            &nbsp;
            Categorias
        </div>
    </div>

    <div class="col-md-3 espaco-padrao"  style="display:<?=$cssDisplay?>">
        <div class="menu" onclick="document.location.href='./?p=<?=$linkUsuariosInstituicoes?>&idi=<?=$idInstituicao?>'">
            <i class="glyphicon glyphicon-user"></i>
            &nbsp;
            Usuários
        </div>
    </div>
    
    <div class="col-md-3 espaco-padrao" style="display:<?=$cssDisplay?>" title="<?=$infoEditar?>" alt="<?=$infoEditar?>">
        <div class="menu" onclick="document.location.href='./?p=<?=$linkEditar?>&idi=<?=$idInstituicao?>'">
            <i class="glyphicon glyphicon-edit"></i>
            &nbsp;
            Editar Instituição
        </div>
    </div>

    <div class="col-md-3 espaco-padrao" style="display: none;">
        <div class="menu" onclick="">
            <i class="glyphicon glyphicon-barcode"></i>
            &nbsp;
            Faturas
        </div>
    </div>

    <?php
    }
    ?>
</section>

<script src="./app/view/js/dashboard_instituicao.js"></script>