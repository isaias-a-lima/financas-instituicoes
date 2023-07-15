<?php

use app\controller\RenderController;
use app\controller\UsuarioController;
use app\lib\SecurityUtil;
use app\model\entities\Usuario;

$error = "";

include "./app/view/sessionInfo.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    try {

        $user = new Usuario();
        $user->setIdUsuario(isset($_POST['id-usuario']) ? SecurityUtil::sanitizeInteger($_POST['id-usuario']) : 0);
        $user->setRg(isset($_POST['rg']) ? SecurityUtil::sanitizeString($_POST['rg']) : null);
        $user->setNome(isset($_POST['nome']) ? SecurityUtil::sanitizeString($_POST['nome']) : null);
        $user->setEmail(isset($_POST['email']) ? SecurityUtil::sanitizeString($_POST['email']) : null);

        $usuarioController = new UsuarioController();
        $usuarioController->updateUsuario($user);
    } catch (Exception $e) {
        $msg = $e->getMessage();
        $error = "<div class='alert alert-danger'>$msg</div>";
    }
}

$usuarioController = new UsuarioController();
$user2 = $usuarioController->getUsuario($usuario->getIdUsuario());

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
            <li class="active">Meus Dados</li>
        </ol>
    </div>
</section>

<section class="row">
    <div class="col-sm-6">
        <h3>Meus dados</h3>
        <?= $error ?>
        <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
            <input type="hidden" id="id-usuario" name="id-usuario" value="<?= $user2->getIdUsuario() ?>">
            <div class="form-group">
                <label for="rg">RG</label>
                <input class="form-control" type="text" name="rg" id="rg" required value="<?= $user2->getRg() ?>" />
            </div>
            <div class="form-group">
                <label for="nome">Nome</label>
                <input class="form-control" type="text" name="nome" id="nome" required value="<?= $user2->getNome() ?>" />
            </div>
            <div class="form-group">
                <label for="email">E-mail</label>
                <input class="form-control" type="mail" name="email" id="email" required value="<?= $user2->getEmail() ?>" />
            </div>
            <input class="btn btn-primary" type="submit" value="Salvar" />
        </form>
    </div>
</section>