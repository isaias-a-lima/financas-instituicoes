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
    <div class="col-md-12">
        <h3>
            Instituições
            <a href="./?p=<?= RenderController::PAGES['CADASTRO_INSTITUICAO']['cod'] ?>" title="Incluir nova instituição" alt="Incluir nova instituição" class="icones">
                <span class="glyphicon glyphicon-plus"></span>
            </a>
        </h3>
    </div>
</section>

<section class="row">
    <div class="col-md-12">
        <?php echo $instituicaoController->renderizeAllInstituicoes($usuario->getIdUsuario()); ?>
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

<script>
    function openAvisoModal() {
        $("#avisoModal").css("top", "0");
        $("#avisoModal").css("left", "0");
        $("#avisoModal").css("width", "100%");
        $("#avisoModal").css("height", "100%");
        $("#avisoModal").show();
        setTimeout("closeAvisoModal()", 3000);
    }

    function closeAvisoModal() {
        $("#avisoModal").css("display", "none");
    }


    function openUserModal(idIntituicao) {
        resetModal();
        $("#idInstituicao").val(idIntituicao);
        $("#userModal").modal();
    }

    function convidar() {
        let email = $("#e-mail").val();
        let funcao = $("#funcao").val();
        let idInstituicao = $("#idInstituicao").val();

        if (email.length == 0) {
            $("#e-mail").css("border-color", "red");
            $("#e-mail").focus();
        } else if (funcao.length == 0) {
            $("#e-mail").css("border-color", "");
            $("#funcao").css("border-color", "red");
            $("#funcao").focus();
        } else if (idInstituicao.length == 0) {
            $("#errorModel").text("ID da instituição é obrigatório.");
            $("#errorModel").css("display", "block");
        } else {
            const msg = email + " | " + funcao + " | " + idInstituicao;
            $("#userModal").modal("hide");
            openAvisoModal()
        }
    }

    function resetModal() {
        $("#e-mail").css("border-color", "");
        $("#e-mail").val("");
        $("#funcao").css("border-color", "");
        $("#funcao").val("");
        $("#idInstituicao").css("border-color", "");
        $("#idInstituicao").val("");
        $("#errorModel").text("");
        $("#errorModel").css("display", "none");
    }
</script>