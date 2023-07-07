<?php

use app\controller\SessionController;

$sessao = SessionController::getInstance();

$usuario = $sessao->getSessionUser();

$exit = "<a href='./?p=0' title='Sair' alt='Sair' class='icones'><span class='glyphicon glyphicon-log-out'></span></a>";
$edit = "<a href='./?p=5&usuario=" .$usuario->getIdUsuario() . "' title='Editar meus dados' alt='Editar meus dados' class='icones'><span class='glyphicon glyphicon-edit'></span></a>";
$welcome = "<p>Bem vindo(a) " . $usuario->getNome() . $edit . $exit . "</p>";

$msg = isset($_GET['msg']) ? $_GET['msg'] : null;
$error = isset($msg) ? "<div id='errorMsg' class='alert alert-success'>$msg</div>" : "";

?>

<section class="row">
    <div class="col-sm-12">
        <?=$welcome?>        
    </div>
</section>

<section class="row">
    <div class="col-sm-12">
        <?=$error?>                  
    </div>
</section>

<?php include "instituicoes.php"; ?>

<script>    
    $(document).ready(function(){
        $("#errorMsg").fadeOut(5000);
    });
</script>