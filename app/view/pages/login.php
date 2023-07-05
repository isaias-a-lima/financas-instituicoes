<?php

use app\controller\LoginController;
use app\controller\RenderController;
use app\lib\SecurityUtil;

$error = isset($_GET['msg']) ? SecurityUtil::sanitizeString($_GET['msg']) : "";
$error = !empty($error) ? "<div class='alert alert-danger'>$error</div>" : "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $senha = isset($_POST['senha']) ? $_POST['senha'] : '';
    try {
        $loginController = new LoginController();
        $loginController->login($email, $senha);
    } catch (Exception $e) {
        $msg = $e->getMessage();
        $error = "<div class='alert alert-danger'>$msg</div>";
    }
}

?>
<section class="row">
    <div class="col-sm-6">
        <h3>Entrar</h3>
        <?= $error ?>
        <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
            <div class="form-group">
                <label for="email">E-mail</label>
                <input class="form-control" type="mail" name="email" id="email" required />
            </div>
            <div class="form-group">
                <label for="senha">Senha</label>
                <input class="form-control" type="password" name="senha" id="senha" required />
            </div>
            <input class="btn btn-default" type="submit" value="Entrar" />
        </form>
    </div>
</section>
<section class="row">
    <div class="col-sm-12">
        <a href="./?p=<?php echo RenderController::PAGES['CADASTRO_USUARIO']['cod']; ?>">Ainda não tem cadastro? Clique aqui para cadastrar-se!</a><br>
        <a href="./?p=<?php echo RenderController::PAGES['RESETAR_SENHA']['cod']; ?>">Esqueci minha senha!</a>
    </div>
</section>