<?php

use app\controller\InstituicaoController;
use app\controller\RenderController;
use app\controller\SessionController;
use app\lib\SecurityUtil;
use app\model\entities\Instituicao;
use app\model\entities\Usuario;

$error = "";

$sessao = SessionController::getInstance();

$usuario = $sessao->getSessionUser();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    try {

        $instituicao = new Instituicao();
        $instituicao->setIdInstituicao(isset($_POST['idInstituicao']) ? $_POST['idInstituicao'] : null);
        $instituicao->setCnpj(isset($_POST['cnpj']) ? $_POST['cnpj'] : null);
        $instituicao->setNome(isset($_POST['nome']) ? $_POST['nome'] : null);
        $instituicao->setEmail(isset($_POST['email']) ? $_POST['email'] : null);
        $instituicao->setEmailContab(isset($_POST['emailcontab']) ? $_POST['emailcontab'] : null);
        $instituicao->setDataCadastro(isset($_POST['datacadastro']) ? $_POST['datacadastro'] : null);

        $controller = new InstituicaoController();
        $controller->updateInstituicao($instituicao);
    } catch (Exception $e) {
        $msg = $e->getMessage();
        $error = "<div class='alert alert-danger'>$msg</div>";
    }
} else {
    $idInstituicao = isset($_GET['idi']) ? SecurityUtil::sanitizeString($_GET['idi']) : 0;
    $controller = new InstituicaoController();
    $instituicao = $controller->getById($idInstituicao);
    $dataCadastro = date("d/m/Y", strtotime($instituicao->getDataCadastro()));
}

include "./app/view/sessionInfo.php";

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
            <li>
                <a href="./?p=<?= RenderController::PAGES['DASHBOARD_INSTITUICAO']['cod'] ?>&idi=<?=$idInstituicao?>">
                    Dashboard
                </a>
            </li>
            <li class="active">Edição de Dados da Instituição</li>
        </ol>
    </div>
</section>

<h2><?= $instituicao->getNome() ?></h2>

<section class="row">
    <div class="col-md-12">
        <h3>Edição de Dados da Instituição</h3>
    </div>
</section>

<section class="row">
    <div class="col-sm-6">
        <?= $error ?>
        <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
            <input type="hidden" name="idInstituicao" id="idInstituicao" value="<?=$instituicao->getIdInstituicao()?>" />

            <div class="form-group">
                <label for="cnpj">CNPJ da instituição</label>
                <input class="form-control" type="text" name="cnpj" id="cnpj" value="<?=$instituicao->getCnpj()?>" required />
            </div>
            <div class="form-group">
                <label for="nome">Nome da instituição</label>
                <input class="form-control" type="text" name="nome" id="nome" value="<?=$instituicao->getNome()?>" required />
            </div>
            <div class="form-group">
                <label for="email">E-mail da instituição</label>
                <input class="form-control" type="mail" name="email" id="email" value="<?=$instituicao->getEmail()?>" required />
            </div>
            <div class="form-group">
                <label for="emailcontab">E-mail da contabilidade</label>
                <input class="form-control" type="mail" name="emailcontab" id="emailcontab" value="<?=$instituicao->getEmailContab()?>" required />
            </div>
            <div class="form-group">
                <label for="datacadastro">Data de cadastro</label>
                <input class="form-control" type="date" name="datacadastro" id="datacadastro" value="<?=$instituicao->getDataCadastro()?>" readonly />
            </div>
            
            <input class="btn btn-primary" type="submit" value="Salvar" />
        </form>
    </div>
</section>
<p>&nbsp;</p>