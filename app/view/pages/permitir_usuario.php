<?php

use app\controller\InstituicaoController;
use app\controller\RenderController;
use app\controller\UsuarioController;
use app\exceptions\ExceptionUtil;
use app\lib\SecurityUtil;
use app\model\entities\Usuario;

$errorMsg = "";
$isBtnSalvarActive = "";

try {
    $instituicaoController = new InstituicaoController();
    $usuarioController = new UsuarioController();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $idUsuarioPost = isset($_POST['idUsuario']) ? SecurityUtil::sanitizeString($_POST['idUsuario']) : null;
        $idInstituicaoPost = isset($_POST['idi']) ? SecurityUtil::sanitizeString($_POST['idi']) : null;
        $funcaoPost = isset($_POST['funcao']) ? SecurityUtil::sanitizeString($_POST['funcao']) : null;
                
        $instituicaoController->saveUsuariosInstituicao($idUsuarioPost, $idInstituicaoPost, $funcaoPost);
        
    }

    $idInstituicao = isset($_GET['idi']) ? SecurityUtil::sanitizeString($_GET['idi']) : 0;
    $email = isset($_GET['e-mail']) ? SecurityUtil::sanitizeString($_GET['e-mail']) : "";
    $funcao = isset($_GET['funcao']) ? SecurityUtil::sanitizeString($_GET['funcao']) : "";

    $usuario = $usuarioController->getUsuarioByEmail($email);    

    $idUser = $rgUser = $nomeUser = $emailUser = "";

    $hasUser = false;

    if (isset($usuario) && is_object($usuario)) {
        $idUser = $usuario->getIdUsuario();
        $rgUser = $usuario->getRg();
        $nomeUser = $usuario->getNome();
        $emailUser = $usuario->getEmail();
        $hasUser = true;
    } else {
        $isBtnSalvarActive = " disabled ";
        $m = "
        Não existe usuário cadastrado no sistema com esse e-mail (<strong>$email</strong>).<br>
        Peça ao usuário para cadastrar-se no sistema, e depois poderá permitir o seu acesso à instituição.
        ";
        throw new Exception($m);
    }

    $hasPermissao = $hasUser ? $instituicaoController->hasPermissao($idUser, $idInstituicao) : false;

    if ($hasPermissao) {
        $isBtnSalvarActive = " disabled ";
        $m = "
        O usuário já tem permissão de acesso a essa instituição.<br>
        Peça ao usuário para fazer o login com o e-mail <strong>$email</strong>        
        ";
        throw new Exception($m);
    }

} catch (Exception $e) {
    $msg = ExceptionUtil::handleError($e);
    $errorMsg = "<div class='alert alert-danger'>$msg</div>";
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
            <li><a href="./?p=<?= RenderController::PAGES['LISTAR_INSTITUICOES']['cod'] ?>">Instituições</a></li>
            <li>
                <a href="./?p=<?= RenderController::PAGES['DASHBOARD_INSTITUICAO']['cod'] ?>&idi=<?=$idInstituicao?>">
                    Painel
                </a>
            </li>
            <li class="active">Permitir Acesso de Usuário</li>
        </ol>
    </div>
</section>

<section class="row">
    <div class="col-md-6">
        <h3>Permitir Acesso de Usuário à Instituição</h3>
        <?= $errorMsg ?>
        <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
            <input type="hidden" name="idi" value="<?=$idInstituicao?>" />
            <input type="hidden" name="idUsuario" value="<?=$idUser?>" />
            <input type="hidden" name="funcao" value="<?=$funcao?>" />
            <div class="form-group">
                <label for="rg">RG</label>
                <input class="form-control" type="text" name="rg" id="rg" value="<?=$rgUser?>" readonly required />
            </div>
            <div class="form-group">
                <label for="nome">Nome</label>
                <input class="form-control" type="text" name="nome" id="nome" value="<?=$nomeUser?>" readonly  required />
            </div>
            <div class="form-group">
                <label for="email">E-mail</label>
                <input class="form-control" type="mail" name="email" id="email" value="<?=$emailUser?>" readonly required />
            </div>
            <input class="btn btn-primary" type="submit" value="Salvar" <?=$isBtnSalvarActive?> />
        </form>
    </div>
</section>