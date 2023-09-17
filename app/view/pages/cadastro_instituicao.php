<?php

use app\controller\InstituicaoController;
use app\controller\RenderController;
use app\controller\SessionController;
use app\exceptions\ExceptionUtil;
use app\model\entities\Instituicao;
use app\model\entities\Usuario;

$msgError = "";

$sessao = SessionController::getInstance();

$usuario = $sessao->getSessionUser();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    try {

        $instituicao = new Instituicao();
        $instituicao->setCnpj(isset($_POST['cnpj']) ? $_POST['cnpj'] : null);
        $instituicao->setNome(isset($_POST['nome']) ? $_POST['nome'] : null);
        $instituicao->setEmail(isset($_POST['email']) ? $_POST['email'] : null);
        $instituicao->setEmailContab(isset($_POST['emailcontab']) ? $_POST['emailcontab'] : null);
        $instituicao->setDataCadastro(date('Ymd'));
        $titular = new Usuario();
        $titular->setIdUsuario($usuario->getIdUsuario());
        $instituicao->setTitular($titular);

        $controller = new InstituicaoController();
        $controller->saveInstituicao($instituicao);
    } catch (Exception $e) {        
        $msg = ExceptionUtil::handleError($e);
        $msgError = "<div class='alert alert-danger'>$msg</div>";
    }
}

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
            <li>
                <a href="./?p=<?= RenderController::PAGES['LISTAR_INSTITUICOES']['cod'] ?>">
                    Instituições
                </a>
            </li>
            <li class="active">Cadastrar Instituição</li>
        </ol>
    </div>
</section>

<h3>Cadastrar Instituição</h3>

<section class="row">
    <div class="col-sm-6">        
        <?=$msgError?>
        <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
            <div class="form-group">
                <label for="cnpj">CNPJ da instituição</label>
                <input class="form-control" type="text" name="cnpj" id="cnpj" required />
            </div>
            <div class="form-group">
                <label for="nome">Nome da instituição</label>
                <input class="form-control" type="text" name="nome" id="nome" required />
            </div>
            <div class="form-group">
                <label for="email">E-mail da instituição</label>
                <input class="form-control" type="mail" name="email" id="email" required />
            </div>
            <div class="form-group">
                <label for="emailcontab">E-mail da contabilidade</label>
                <input class="form-control" type="mail" name="emailcontab" id="emailcontab" required />
            </div>
            <input class="form-control" type="hidden" name="idusuarioresp" id="idusuarioresp" value="<?= $usuario->getIdUsuario() ?>" required />            
            <input class="btn btn-primary" type="submit" value="Salvar" />
        </form>
    </div>
</section>
<p>&nbsp;</p>