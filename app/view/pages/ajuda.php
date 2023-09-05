<?php

use app\controller\RenderController;

$msgError = "";

include "./app/view/sessionInfo.php";

?>

<section class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">
            <li>
                <a href="./?p=<?= RenderController::PAGES['HOME']['cod'] ?>">
                    <i class="glyphicon glyphicon-arrow-left"></i>
                    Home
                </a>
            </li>
            <li class="active">Ajuda</li>
        </ol>
    </div>
</section>

<section class="row">
    <div class="col-md-12">
        <h3>Ajuda</h3>
        <?= $msgError ?>
    </div>
</section>