<?php
date_default_timezone_set("America/Sao_Paulo");

use app\controller\SessionController;

$sessao = SessionController::getInstance();

$usuario = $sessao->getSessionUser();

$exit = "
    <a href='./?p=0' 
    title='Sair' 
    alt='Sair' 
    class='icones'>
    <span class='glyphicon glyphicon-log-out'></span> <small>Sair</small>
    </a>";

$welcome = "Bem vindo(a) " . $usuario->getNome() . $exit;

$msg = isset($_GET['msg']) ? $_GET['msg'] : null;
$error = isset($msg) ? "<div id='errorMsg' class='alert alert-success'>$msg</div>" : "";

?>

<section class="row">
    <div class="col-sm-12 text-right">
        <?= $welcome ?>
    </div>
</section>

<section class="row">
    <div class="col-sm-12">
        <?= $error ?>
    </div>
</section>

<script>
    $(document).ready(function() {
        $("#errorMsg").fadeOut(5000);
    });
</script>