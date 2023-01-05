<?php

use app\controller\SessionController;

$usuario = SessionController::getSessionUser();
$exit = "<a href='./?p=0'>Logout</a>";
$welcome = "<p>Bem vindo(a) " . $usuario->getNome() . " - " . $exit . "</p>";
?>
<?=$welcome?>
<h1>Home</h1>
<p>
    Nonono nonono.<br>
    Nonono nonono.<br>
    Nonono nonono.<br>
</p>