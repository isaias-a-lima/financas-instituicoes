<iframe name="enviar" width="1px" height="1px" style="border: 0;"></iframe>

<form name="enviarform" method="post" action="./app/lib/enviaMail.php" target="enviar">
    <input type="hidden" name="to">
    <input type="hidden" name="subject">
    <input type="hidden" name="message">
    <input type="hidden" name="from">
</form>

<script src="./app/view/js/resetar_senha.js"></script>

<?php

use app\controller\RenderController;
use app\controller\UsuarioController;
use app\lib\SecurityUtil;
use app\model\entities\Usuario;

$error = isset($_GET['msg']) ? SecurityUtil::sanitizeString($_GET['msg']) : 
    (isset($_POST['msg']) ? SecurityUtil::sanitizeString($_POST['msg']) : "");
$error = !empty($error) ? "<div id='errorMsg' class='alert alert-warning'>$error</div>" : "";

$mensagem = null;

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
            $local = isset($_POST['local']) ? SecurityUtil::sanitizeString($_POST['local']) : "";
            $usuarioController = new UsuarioController();
            $mensagem = $usuarioController->resetarSenhaEtapa1($email, $local);
            $json = json_encode($mensagem);
            if(isset($mensagem)) {
                echo "<script>resetarSenhaEtapa1($json)</script>";
            }
        }
        
    } catch (Exception $e) {
        $msg = $e->getMessage();
        $error = "<div id='errorMsg' class='alert alert-danger'>$msg</div>";
    }
}

$step = isset($_GET['step']) ? $_GET['step']: 1;

if ($step == 2) {
?>
<section class="row">
    <div class="col-sm-6">
        <h3>Resetar senha</h3>
        <?=$error?>
        <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
            <input type="hidden" name="step" value="2" />
            <div class="form-group">
                <label for="rg">RG</label>
                <input class="form-control" type="text" name="rg" id="rg" placeholder="Digite seu RG" required />
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

<p>&nbsp;</p>

<section class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">
            <li>
                <a href="./?p=<?= RenderController::PAGES['LOGIN']['cod'] ?>">
                    <span class="glyphicon glyphicon-arrow-left"></span> Voltar
                </a>
            </li>
            <li class="active">Resetar Senha</li>
        </ol>
    </div>
</section>

<section class="row">
    <div class="col-sm-6">
        <h3>Resetar senha</h3>
        <?=$error?>
        <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
            <input type="hidden" name="step" value="1" />
            <div class="form-group">
                <label for="email">E-mail</label>
                <input class="form-control" type="mail" name="email" id="email" placeholder="Digite seu e-mail" required />
            </div>
            
            <input type="hidden" id="resetMsg" name="msg">
            <input type="hidden" id="local" name="local">

            <input class="btn btn-primary" type="submit" value="Resetar" />
        </form>
    </div>
</section>
<?php
}
?>

<script src="./app/view/js/shared.js"></script>

