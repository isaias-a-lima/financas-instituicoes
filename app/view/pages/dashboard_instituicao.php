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

$idInstituicao = isset($_GET['idi']) ? $_GET['idi'] : '';

$instituicaoController = new InstituicaoController();

$instituicao = $instituicaoController->getById($idInstituicao);

$isTitular = $usuario->getIdUsuario() == $instituicao->getTitular()->getIdUsuario();
$cssDisplay = $isTitular ? "block" : "none";

$infoEditar = "Editar dados da instituição";
$infoAddUser = "Adicionar usuários à instituição";
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

    <div class="col-md-3 espaco-padrao">
        <div class="menu" onclick="">
            <i class="glyphicon glyphicon-usd text-warning"></i>
            &nbsp;
            Contas
        </div>
    </div>

    <div class="col-md-3 espaco-padrao">
        <div class="menu" onclick="">
            <i class="glyphicon glyphicon-cog"></i>
            &nbsp;
            Categorias
        </div>
    </div>

    <div class="col-md-3 espaco-padrao" style="display:<?=$cssDisplay?>" title="<?=$infoAddUser?>" alt="<?=$infoAddUser?>">
        <div class="menu" onclick="openUserModal(<?=$idInstituicao?>)">
            <i class="glyphicon glyphicon-user"></i>
            &nbsp;
            Adicionar usuário
        </div>
    </div>

    <div class="col-md-3 espaco-padrao" style="display:<?=$cssDisplay?>" title="<?=$infoEditar?>" alt="<?=$infoEditar?>">
        <div class="menu" onclick="document.location.href='./?p=<?=$linkEditar?>&idi=<?=$idInstituicao?>'">
            <i class="glyphicon glyphicon-edit"></i>
            &nbsp;
            Editar Instituição
        </div>
    </div>

    <div class="col-md-3 espaco-padrao">
        <div class="menu" onclick="">
            <i class="glyphicon glyphicon-barcode"></i>
            &nbsp;
            Faturas
        </div>
    </div>
</section>

<div id="userModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close glyphicon glyphicon-remove" data-dismiss="modal"></span>
                <h4>Convidar alguém para ter acesso à instituição</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label>E-mail</label>
                        <input type="email" id="e-mail" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Função</label>
                        <select id="funcao" class="form-control">
                            <option value="">...</option>
                            <option value="Tesoureiro">Tesoureiro(a)</option>
                            <option value="Fiscal">Fiscal</option>
                        </select>
                    </div>
                    <input type="hidden" id="idInstituicao" placeholder="instituição">
                </form>
                <div class="alert alert-danger" id="errorModel" style="display: none;">
                </div>
            </div>
            <div class="modal-footer">
                <button onclick="convidar()" class="btn btn-primary"><span class="glyphicon glyphicon-log-out"></span> Convidar </button>
            </div>
        </div>
    </div>
</div>

<div id="avisoModal" style="position:fixed; z-index:9999; background-color:rgba(0, 0, 0, 0.8); display:none;">
    <div class="alert alert-success" style="position:relative; width:80%; margin: 0 10%; top:100px;">
        Convite enviado com sucesso!
    </div>
</div>

<script src="./app/view/js/dashboard_instituicao.js"></script>