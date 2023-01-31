<?php

use app\controller\RenderController;
use app\controller\UsuarioController;
use app\lib\SecurityUtil;
use app\model\entities\Usuario;

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    try {
        if ($_POST['step'] == 2) {
            $usuario = new Usuario();            
            $usuario->setRg(isset($_POST['rg']) ? SecurityUtil::sanitizeString($_POST['rg']) : null);            
            $usuario->setEmail(isset($_POST['email']) ? SecurityUtil::sanitizeString($_POST['email']) : null);
            $usuario->setSenha(isset($_POST['senha']) ? SecurityUtil::getHashPassword(SecurityUtil::sanitizeString($_POST['senha'])) : null);

            $usuarioController = new UsuarioController();
            $usuarioController->resetarSenhaEtapa2($usuario);
            
        } else {
            $email = isset($_POST['email']) ? SecurityUtil::sanitizeString($_POST['email']) : "";
            $usuarioController = new UsuarioController();
            $usuarioController->resetarSenhaEtapa1($email);
        }
        
    } catch (Exception $e) {
        $msg = $e->getMessage();
        $error = "<div class='alert alert-danger'>$msg</div>";
    }
}

$step = isset($_GET['step']) ? $_GET['step']: 1;

if ($step == 2) {
?>
<section class="row">
    <div class="col-sm-6">
        <h2>Resetar senha</h2>
        <?=$error?>
        <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
            <input type="hidden" name="step" value="2" />
            <div class="form-group">
                <label for="rg">RG</label>
                <input class="form-control" type="mail" name="rg" id="rg" placeholder="Digite seu RG" required />
            </div>
            <div class="form-group">
                <label for="email">E-mail</label>
                <input class="form-control" type="mail" name="email" id="email" placeholder="Digite seu e-mail" required />
            </div>
            <div class="form-group">
                <label for="senha">Nova senha</label>
                <input class="form-control" type="password" name="senha" id="senha" placeholder="Digite uma nova senha" required />
            </div>
            <input class="btn btn-primary" type="submit" value="Salvar" />
        </form>
    </div>
</section>
<?php
} else {
?>
<div class="row">
    <div class="col-md-12">
        <ul class="pager">
            <li class="previous"><a href="./?p=<?= RenderController::PAGES['LOGIN']['cod'] ?>" class="btn btn-default">Voltar</a></li>
        </ul>
    </div>
</div>
<section class="row">
    <div class="col-sm-6">
        <h2>Resetar senha</h2>
        <?=$error?>
        <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
            <input type="hidden" name="step" value="1" />
            <div class="form-group">
                <label for="email">E-mail</label>
                <input class="form-control" type="mail" name="email" id="email" placeholder="Digite seu e-mail" required />
            </div>
            <input class="btn btn-primary" type="submit" value="Resetar" />
        </form>
    </div>
</section>
<?php
}
?>