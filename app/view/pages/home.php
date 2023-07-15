<?php

use app\controller\RenderController;

include "./app/view/sessionInfo.php";

$linkEditarUsuario = RenderController::PAGES["EDITAR_USUARIO"]["cod"];
$linkListarInstituicoes = RenderController::PAGES["LISTAR_INSTITUICOES"]["cod"];
?>

<section class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">
            <li class="active">Home</li>
        </ol>
    </div>
</section>

<section class="row">
    <div class="col-md-3">
        <div class="menu" onclick="document.location.href='./?p=<?=$linkListarInstituicoes?>'">
            <i class="glyphicon glyphicon-list"></i>
            &nbsp;
            Instituições
        </div>
    </div>
    <div class="col-md-3">
        <div class="menu">
            <i class="glyphicon glyphicon-question-sign"></i>
            &nbsp;
            Ajuda
        </div>
    </div>
    <div class="col-md-3">
        <div class="menu">
            <i class="glyphicon glyphicon-earphone"></i>
            &nbsp;
            Contato
        </div>
    </div>
    <div class="col-md-3">
        <div class="menu" onclick="document.location.href='./?p=<?=$linkEditarUsuario?>'">
            <i class="glyphicon glyphicon-user"></i>
            &nbsp;
            Meus Dados
        </div>
    </div>
</section>