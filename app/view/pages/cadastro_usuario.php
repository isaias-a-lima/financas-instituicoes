<?php

use app\controller\RenderController;
use app\controller\UsuarioController;
use app\exceptions\ExceptionUtil;
use app\lib\SecurityUtil;
use app\model\entities\Usuario;

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    try {

        $usuario = new Usuario();
        $usuario->setRg(isset($_POST['rg']) ? $_POST['rg'] : null);
        $usuario->setNome(isset($_POST['nome']) ? $_POST['nome'] : null);
        $usuario->setEmail(isset($_POST['email']) ? $_POST['email'] : null);
        $senha = isset($_POST['senha']) ? SecurityUtil::getHashPassword($_POST['senha']) : null;
        $usuario->setSenha($senha);
        $usuario->setDataCadastro(date('Ymd'));

        $usuarioController = new UsuarioController();
        $usuarioController->saveUsuario($usuario);
    } catch (Exception $e) {
        $msg = ExceptionUtil::handleError($e);
        $error = "<div class='alert alert-danger'>$msg</div>";
    }
}

?>
<p>&nbsp;</p>

<section class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">
            <li>
                <a href="./?p=<?= RenderController::PAGES['HOME']['cod'] ?>">
                    <span class="glyphicon glyphicon-arrow-left"></span> Home
                </a>
            </li>
            <li class="active">Cadastro de Usuário</li>
        </ol>
    </div>
</section>

<section class="row">
    <div class="col-md-6">
        <h3>Cadastro de Usuário</h3>
        <?= $error ?>
        <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
            <div class="form-group">
                <label for="rg">RG</label>
                <input class="form-control" type="text" name="rg" id="rg" required />
            </div>
            <div class="form-group">
                <label for="nome">Nome</label>
                <input class="form-control" type="text" name="nome" id="nome" required />
            </div>
            <div class="form-group">
                <label for="email">E-mail</label>
                <input class="form-control" type="mail" name="email" id="email" required />
            </div>
            <div class="form-group">
                <label for="senha">Senha</label>
                <input class="form-control" type="password" name="senha" id="senha" required />
            </div>
            <input class="btn btn-primary" type="submit" value="Salvar" />
        </form>
    </div>
</section>