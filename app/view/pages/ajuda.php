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
        <ol class="ajuda">
            <li><a href="#help1">Cadastrar uma Instituição.</a></li>
            <li><a href="#help2">Cadastrar Entradas e Saídas.</a></li>
            <li><a href="#help3">Realizar Fechamento do Mês.</a></li>
        </ol>
        <hr>

        <h4>O que significam as categorias de Entrada?</h4>
        <ul class="ajuda">
            <li><a href="#help4">Doações Recebidas.</a></li>
            <li><a href="#help5">Doações Designadas.</a></li>
            <li><a href="#help6">Ofertas Recebidas.</a></li>
            <li><a href="#help7">Rendas de Eventos.</a></li>
        </ul>
        <hr>

        <h4>O que significa cada categoria de Saída?</h4>
        <ul class="ajuda">
            <li><a href="#help8">Custos Administrativos.</a></li>
            <li><a href="#help9">Salários Eclesiásticos.</a></li>
            <li><a href="#help10">Despesas Ministeriais.</a></li>
            <li><a href="#help11">Despesas de Manutenção do Edifício.</a></li>
            <li><a href="#help12">Contribuições para Causas Externas.</a></li>
        </ul>
        <hr>
    </div>

    <div class="col-md-12">
        <ol class="ajuda">
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

        <ol class="ajuda">
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

        <ol class="ajuda">
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

        <hr>

        <h4>O que significam as categorias de Entrada?</h4>
        <img src="./app/view/images/ajuda_categorias_entradas.png" style="width: 100%; max-width: 613px;" />
        <ul class="ajuda">
            <li><a name="help4"></a>
                <dt>Doações Recebidas.</dt>
                <dd>
                    Muitas igrejas dependem das doações regulares feitas pelos seus membros.
                    Essas contribuições podem ocorrer semanalmente, mensalmente ou em outras frequências
                    determinadas pelos fiéis. Um exemplo desse tipo de doação é o Dízimo.
                </dd>
            </li>
            <li><a name="help5"></a>
                <dt>Doações Designadas.</dt>
                <dd>
                    Além das contribuições regulares, os membros da igreja podem fazer doações adicionais para
                    projetos específicos, eventos especiais, obras de caridade, entre outros propósitos.
                    Essas doações tem seu objetivo pré-definido.
                </dd>
            </li>
            <li><a name="help6"></a>
                <dt>Ofertas Recebidas.</dt>
                <dd>
                    Durante os cultos, as igrejas geralmente fazem uma coleta onde os fiéis têm a oportunidade
                    de contribuir financeiramente para apoiar as atividades e necessidades da igreja.
                </dd>
            </li>
            <li><a name="help7"></a>
                <dt>Rendas e Eventos.</dt>
                <dd>
                    As igrejas podem realizar eventos, como bazares, festas, conferências ou concertos, que
                    geram receita por meio da venda de ingressos ou produtos, como alimentos, artesanatos ou
                    livros.
                </dd>
            </li>
        </ul>

        <hr>

        <h4>O que significam as categorias de Saída?</h4>
        <img src="./app/view/images/ajuda_categorias_saidas.png" style="width: 100%; max-width: 613px;" />
        <ul class="ajuda">
            <li><a name="help8"></a>
                <dt>Custos Administrativos.</dt>
                <dd>
                    Assim como outras organizações, as igrejas têm despesas administrativas, incluindo salários
                    dos funcionários, aluguel ou manutenção do prédio, contas de serviços públicos, seguros,
                    material de escritório, entre outros.
                </dd>
            </li>
            <li><a name="help9"></a>
                <dt>Salários Eclesiásticos.</dt>
                <dd>
                    As igrejas podem ter despesas relacionadas ao sustento dos ministros e líderes religiosos, 
                    como salários, benefícios, moradia e ajuda de custo.
                </dd>
            </li>
            <li><a name="help10"></a>
                <dt>Despesas Ministeriais.</dt>
                <dd>
                    As igrejas podem oferecer uma variedade de programas e atividades para os membros e a 
                    comunidade, como grupos de estudo, ministérios, eventos de evangelização, grupos de jovens, 
                    obras de caridade e assistência social. Essas atividades podem envolver despesas com 
                    materiais, transporte, alimentação, entre outros.
                </dd>
            </li>
            <li><a name="help11"></a>
                <dt>Despesas de Manutenção do Edifício.</dt>
                <dd>
                    As igrejas precisam manter e, ocasionalmente, fazer melhorias em seus edifícios e 
                    instalações. Isso pode incluir reparos, limpeza, segurança, reformas e projetos de 
                    construção.
                </dd>
            </li>
            <li><a name="help12"></a>
                <dt>Contribuições para Causas Externas.</dt>
                <dd>
                    As igrejas também podem realizar contribuições para outras instituições religiosas, 
                    projetos missionários, ações sociais ou causas específicas em linha com sua visão e 
                    valores.
                </dd>
            </li>
        </ul>
    </div>
</section>

<div id="btnGotoTop" class="glyphicon glyphicon-arrow-up" title="Voltar ao topo"></div>
<script src="./app/view/js/verify_doc_width.js"></script>