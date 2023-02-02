<?php

use app\controller\RenderController;
use app\controller\UsuarioController;
use app\lib\SecurityUtil;
use app\model\entities\Usuario;

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    try {

        $usuario = new Usuario();
        $usuario->setIdUsuario(isset($_POST['id-usuario']) ? SecurityUtil::sanitizeInteger($_POST['id-usuario']) : 0);
        $usuario->setRg(isset($_POST['rg']) ? SecurityUtil::sanitizeString($_POST['rg']) : null);
        $usuario->setNome(isset($_POST['nome']) ? SecurityUtil::sanitizeString($_POST['nome']) : null);
        $usuario->setEmail(isset($_POST['email']) ? SecurityUtil::sanitizeString($_POST['email']) : null);

        $usuarioController = new UsuarioController();
        $usuarioController->updateUsuario($usuario);
    } catch (Exception $e) {
        $msg = $e->getMessage();
        $error = "<div class='alert alert-danger'>$msg</div>";
    }
} else {
    $idUsuario = isset($_GET['usuario']) ? SecurityUtil::sanitizeString($_GET['usuario']) : 0;
    $usuarioController = new UsuarioController();
    $usuario = $usuarioController->getUsuario($idUsuario);
}

?>
<div class="row">
    <div class="col-md-12">
        <ul class="pager">
            <li class="previous"><a href="./?p=<?= RenderController::PAGES['HOME']['cod'] ?>" class="btn btn-default">Voltar</a></li>
        </ul>
    </div>
</div>
<section class="row">
    <div class="col-sm-6">
        <h3>Meus dados</h3>
        <?= $error ?>
        <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
            <input type="hidden" id="id-usuario" name="id-usuario" value="<?= $usuario->getIdUsuario() ?>">
            <div class="form-group">
                <label for="rg">RG</label>
                <input class="form-control" type="text" name="rg" id="rg" required value="<?= $usuario->getRg() ?>" />
            </div>
            <div class="form-group">
                <label for="nome">Nome</label>
                <input class="form-control" type="text" name="nome" id="nome" required value="<?= $usuario->getNome() ?>" />
            </div>
            <div class="form-group">
                <label for="email">E-mail</label>
                <input class="form-control" type="mail" name="email" id="email" required value="<?= $usuario->getEmail() ?>" />
            </div>
            <input class="btn btn-primary" type="submit" value="Salvar" />
        </form>
    </div>
</section>