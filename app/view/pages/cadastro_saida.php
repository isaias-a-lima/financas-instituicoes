<?php

use app\controller\CategoriaController;
use app\controller\SaidaController;
use app\controller\FechamentoController;
use app\controller\InstituicaoController;
use app\controller\RenderController;
use app\lib\Constantes;
use app\lib\Validacoes;
use app\model\entities\Categoria;
use app\model\entities\Saida;
use app\model\entities\Usuario;

$instituicao = null;

$msg = "";
$msgError = "";
const SAIDA = "S";
$hasFechamento = false;
$style = "";

try {
    $instituicaoController = new InstituicaoController();
    $categoriaController = new CategoriaController();
    $saidaController = new SaidaController();

    $dataSaida = date("Y-m-d");

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $saida = new Saida();        
        
        $idInstituicao = isset($_POST['idinstituicao']) ? $_POST['idinstituicao'] : "";
        $instituicao = $instituicaoController->getById($idInstituicao);

        $saida->setInstituicao($instituicao);

        $usuario = new Usuario();
        $usuario->setIdUsuario(isset($_POST['idusuario']) ? $_POST['idusuario'] : null);
        $saida->setUsuario($usuario);

        $categoria = new Categoria();
        $categoria->setIdCategoria(isset($_POST['idcategoria']) ? $_POST['idcategoria'] : null);
        $saida->setCategoria($categoria);

        $saida->setDataSaida(isset($_POST['datasaida']) ? $_POST['datasaida'] : null);

        $saida->setDescricao(isset($_POST['descricao']) ? $_POST['descricao'] : null);
        $saida->setValor(isset($_POST['valor']) ? $_POST['valor'] : null);
        $saida->setNumDoc(isset($_POST['numdoc']) ? $_POST['numdoc'] : null);

        $controller = new SaidaController();
        $controller->saveSaida($saida);

    } else {

        $idInstituicao = isset($_GET['idi']) ? $_GET['idi'] : "";
        
        $instituicao = $instituicaoController->getById($idInstituicao);

        $fechamentoController = new FechamentoController();
        $hasFechamento = $fechamentoController->hasFechamento($idInstituicao, $dataSaida);
        Validacoes::isTrueThenRiseMessage($hasFechamento, Constantes::CAN_NOT_SAVE_MOVIMENTACOES);
        
    }

} catch(Exception $e) {
    $msg = $e->getMessage();
    $msgError = "<div class='alert alert-danger'>$msg</div>";
    $style = $hasFechamento == true ? "display: none;" : "";
}

include "./app/view/sessionInfo.php";

?>

<section class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">
            <li>
                <a href="./?p=<?= RenderController::PAGES['HOME']['cod'] ?>">
                    <span class="glyphicon glyphicon-arrow-left"></span> Home
                </a>
            </li>
            <li>
                <a href="./?p=<?= RenderController::PAGES['LISTAR_INSTITUICOES']['cod'] ?>">Instituições</a>
            </li>
            <li>
                <a href="./?p=<?= RenderController::PAGES['DASHBOARD_INSTITUICAO']['cod'] ?>&idi=<?= $idInstituicao ?>">
                    Painel
                </a>
            </li>
            <li>
                <a href="./?p=<?= RenderController::PAGES['LISTAR_SAIDAS']['cod'] ?>&idi=<?= $idInstituicao ?>">
                    Saídas
                </a>
            </li>
            <li class="active">Registrar Saída</li>
        </ol>
    </div>
</section>

<h2><?= $instituicao->getNome() ?></h2>

<section class="row">
    <div class="col-md-12">
        <h3>Registrar Saída</h3>
        <?= $msgError ?>
    </div>
</section>

<section style="<?=$style?>">
    <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
    
        <section class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="datasaida">Data</label>
                    <input class="form-control" type="date" name="datasaida" id="datasaida" value="<?= $dataSaida ?>" required />
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="valor">Valor</label>
                    <input class="form-control" type="number" name="valor" id="valor" min="0" step="0.01" required />
                </div>
            </div>
        </section>
    
        <section class="row">
            <div class="col-md-6">
    
                <div class="form-group">
                    <label for="categoria">Categoria</label>
                    <select class="form-control" name="idcategoria" id="idcategoria" required>
                        <option value="">Escolha uma Categoria...</option>
                        <?= $categoriaController->renderizeSelectOptions(SAIDA) ?>
                    </select>
                </div>
    
                <div class="form-group">
                    <label for="descricao">Descrição</label>
                    <input class="form-control" type="text" name="descricao" id="descricao" required />
                </div>

                <div class="form-group">
                    <label for="numdoc">Número do Documento</label>
                    <input class="form-control" type="text" name="numdoc" id="numdoc" />
                </div>
    
                <input type="hidden" name="idusuario" id="idusuario" value="<?= $usuario->getIdUsuario() ?>" required />
                <input type="hidden" name="idinstituicao" id="idinstituicao" value="<?= $idInstituicao ?>" required />
    
                <input class="btn btn-primary" type="submit" value="Salvar" />
    
            </div>
        </section>
    </form>
</section>