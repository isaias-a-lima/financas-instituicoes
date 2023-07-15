<?php

use app\controller\RenderController;

$idInstituicao = isset($_GET['id']) ? $_GET['id'] : "";

include "./app/view/sessionInfo.php"; 
 
?>

<ul class="pager">
    <li class="previous"><a href="./?p=<?= RenderController::PAGES['LISTAR_ENTRADAS']['cod'] ?>&id=<?=$idInstituicao?>" class="btn btn-default">Voltar</a></li>    
</ul>

<h3>
    Cadastrar Entrada
</h3>