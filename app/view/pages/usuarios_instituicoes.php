<?php

use app\controller\InstituicaoController;
use app\controller\RenderController;
use app\controller\UsuarioController;

$p = isset($_GET['p']) ? $_GET['p'] : '2';
$idInstituicao = isset($_GET['idi']) ? $_GET['idi'] : '';

$instituicaoController = new InstituicaoController();

$instituicao = $instituicaoController->getById($idInstituicao);

$usuarioController = new UsuarioController();

$linkPermitirUser = RenderController::PAGES['PERMITIR_USUARIO']['cod'];

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
            <li class="active">Usuários permitidos</li>
        </ol>
    </div>
</section>

<h2><?= $instituicao->getNome() ?></h2>

<section class="row">
    <div class="col-md-6">
        <h3>Usuários permitidos</h3>
    </div>

    <div class="col-md-6 text-right espaco-padrao">
        <button class="btn btn-info" title="Adicionar entradas" alt="Adicionar entradas" onclick="openUserModal(<?=$idInstituicao?>)">
            <span class="glyphicon glyphicon-plus"></span> Permitir Usuário
        </button>
    </div>
</section>

<section class="row">
    <div class="col-md-12">
        <?php echo $usuarioController->getUsuarioByInstituicao($idInstituicao) ?>
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
                <form id="form-permitir-user" action="<?php $_SERVER['PHP_SELF'] ?>">
                    <div class="form-group">
                        <label>E-mail</label>
                        <input type="email" name="e-mail" id="e-mail" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Função</label>
                        <select name="funcao" id="funcao" class="form-control">
                            <option value="">...</option>
                            <option value="Tesoureiro">Tesoureiro(a)</option>
                            <option value="Fiscal">Fiscal</option>
                        </select>
                    </div>
                    <input type="hidden" name="p" id="p" value="<?=$linkPermitirUser?>" />
                    <input type="hidden" name="idi" id="idi" />
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

<script src="./app/view/js/usuarios_instituicoes.js"></script>