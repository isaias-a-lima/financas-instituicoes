<?php

use app\controller\RenderController;
use app\controller\SessionController;

$usuario = SessionController::getSessionUser();

$exit = "<a href='./?p=0'>Sair.</a>";
$welcome = "<p>Bem vindo(a) " . $usuario->getNome() . " - " . $exit . "</p>";

$msg = isset($_GET['msg']) ? $_GET['msg'] : null;
$error = isset($msg) ? "<div class='alert alert-success'>$msg</div>" : "";

?>
<section class="row">
    <section class="col-sm-12">
        <?=$welcome?>
        <nav class="btn-group">
            <a href="./?p=<?=RenderController::PAGES['CADASTRO_INSTITUICAO']['cod']?>" class="btn btn-primary">Cadastrar instituição</a>
            <a href="#" class="btn btn-primary">Editar meus dados</a>
        </nav>
    </section>
</section>
<section class="row">
    <div class="col-sm-12">

        <?=$error?>

        <?php include "instituicoes.php"; ?>          
    </div>
</section>