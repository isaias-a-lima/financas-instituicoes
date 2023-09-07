<?php

use app\controller\RenderController;

$msgError = "";

include "./app/view/sessionInfo.php";

?>
<a name="topo"></a>
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

<section class="row">
    <div class="col-md-12">
        <h4>Como utilizar o sistema "Tesouraria Prática"?</h4>
        <ol>
            <li><a href="#help1">Cadastrar uma Instituição.</a></li>
            <li><a href="#help2">Cadastrar Entradas e Saídas.</a></li>
            <li><a href="#help3">Realizar Fechamento do Mês.</a></li>
        </ol>
        <hr>
    </div>

    <div class="col-md-12">
        <ol>
            <li>
                <a name="help1">Cadastrar uma Instituição.</a>
                <ol type="a">
                    <li>
                        Clique em "Instituições" para cadastrar ou visualizar suas instituições.
                        <img src="./app/view/images/ajuda_01a_instituicoes.png" style="width: 100%; max-width: 1000px;" />
                    </li>
                    <li>
                        Clique em "Adicionar Instituição" para acessar a tela de cadastro.
                        <img src="./app/view/images/ajuda_01b_instituicoes.png" style="width: 100%; max-width: 1000px;" />
                    </li>
                    <li>
                        Preencha o formulario, e depois clique em Salvar.<br>
                        <img src="./app/view/images/ajuda_01c_instituicoes.png" style="width: 100%; max-width: 635px;" />
                    </li>
                </ol>
            </li>
        </ol>

        <hr>

        <ol>
            <li>
                <a name="help2">Cadastrar Entradas e Saídas.</a>
                <ol type="a">
                    <li>
                        Estando na tela de "Instituições", clique no botão Painel, da Instituição que preferir.
                        <img src="./app/view/images/ajuda_02a_entradas_saidas.png" style="width: 100%; max-width: 1000px;" />
                    </li>
                    <li>
                        Clique em um dos botões, Entradas ou Saídas. O procedimento é semelhante para ambos.
                        <img src="./app/view/images/ajuda_02b_entradas_saidas.png" style="width: 100%; max-width: 903px;" />
                    </li>
                    <li>
                        Clique em Adicionar Entrada/Saída.<br>
                        <img src="./app/view/images/ajuda_02c_entradas_saidas.png" style="width: 100%; max-width: 1000px;" />
                    </li>
                    <li>
                        Preencha o formulário e clique em Salvar.<br>
                        <img src="./app/view/images/ajuda_02d_entradas_saidas.png" style="width: 100%; max-width: 604px;" />
                    </li>
                </ol>
            </li>
        </ol>

        <hr>

        <ol>
            <li>
                <a name="help3">Realizar Fechamento do Mês.</a>
                <ol type="a">
                    <li>
                        Estando na tela de "Instituições", clique no botão Painel, da Instituição que preferir.
                        <img src="./app/view/images/ajuda_03a_fechamentos.png" style="width: 100%; max-width: 1000px;" />
                    </li>
                    <li>
                        Clique no botão Fechamentos.
                        <img src="./app/view/images/ajuda_03b_fechamentos.png" style="width: 100%; max-width: 910px;" />
                    </li>
                    <li>
                        Clique no botão Adicionar Fechamento.<br>
                        <img src="./app/view/images/ajuda_03c_fechamentos.png" style="width: 100%; max-width: 635px;" />
                    </li>
                    <li>
                        O sistema preenche o formulário automaticamente.<br>
                        Se for o primeiro fechamento da Instituição, será necessário preencher o Saldo Inicial manualmente.<br>
                        Não será possível realizar fechamento do mês corrente, apenas de meses passados.
                        Confira se o mês está correto e clique em Salvar<br>
                        <img src="./app/view/images/ajuda_03d_fechamentos.png" style="width: 100%; max-width: 627px;" />
                    </li>
                </ol>
            </li>
        </ol>
    </div>
</section>

<div id="btnGotoTop" class="glyphicon glyphicon-arrow-up" title="Voltar ao topo"></div>
<script src="./app/view/js/verify_doc_width.js"></script>