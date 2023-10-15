<?php

use app\controller\CategoriaController;
use app\controller\EntradaController;
use app\controller\FechamentoController;
use app\controller\InstituicaoController;
use app\controller\RenderController;
use app\lib\Constantes;
use app\lib\Validacoes;
use app\model\entities\Categoria;
use app\model\entities\Entrada;
use app\model\entities\Instituicao;
use app\model\entities\Usuario;

$msg = "";
$msgError = "";
const ENTRADA = "E";
$hasFechamento = false;
$style = "";

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $entrada = new Entrada();
        
        $instituicao = new Instituicao();
        $instituicao->setIdInstituicao(isset($_POST['idinstituicao']) ? $_POST['idinstituicao'] : null);
        $entrada->setInstituicao($instituicao);

        $usuario = new Usuario();
        $usuario->setIdUsuario(isset($_POST['idusuario']) ? $_POST['idusuario'] : null);
        $entrada->setUsuario($usuario);

        $categoria = new Categoria();
        $categoria->setIdCategoria(isset($_POST['idcategoria']) ? $_POST['idcategoria'] : null);
        $entrada->setCategoria($categoria);

        $entrada->setDataEntrada(isset($_POST['dataentrada']) ? $_POST['dataentrada'] : null);

        $entrada->setDescricao(isset($_POST['descricao']) ? $_POST['descricao'] : null);
        $entrada->setValor(isset($_POST['valor']) ? $_POST['valor'] : null);        

        $controller = new EntradaController();
        $controller->saveEntrada($entrada);

    } else {

        $idInstituicao = isset($_GET['idi']) ? $_GET['idi'] : "";

        $dataEntrada = date("Y-m-d");

        $fechamentoController = new FechamentoController();
        $hasFechamento = $fechamentoController->hasFechamento($idInstituicao, $dataEntrada);
        Validacoes::isTrueThenRiseMessage($hasFechamento, Constantes::CAN_NOT_SAVE_MOVIMENTACOES);
        
    }

} catch(Exception $e) {
    $msg = $e->getMessage();
    $msgError = "<div class='alert alert-danger'>$msg</div>";
    $style = $hasFechamento == true ? "display: none;" : "";
}

$instituicaoController = new InstituicaoController();

$instituicao = $instituicaoController->getById($idInstituicao);

$categoriaController = new CategoriaController();

$entradaController = new EntradaController();

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
                <a href="./?p=<?= RenderController::PAGES['LISTAR_ENTRADAS']['cod'] ?>&idi=<?= $idInstituicao ?>">
                    Entradas
                </a>
            </li>
            <li class="active">Registrar Entrada</li>
        </ol>
    </div>
</section>

<h2><?= $instituicao->getNome() ?></h2>

<section class="row">
    <div class="col-md-12">
        <h3>Registrar Entrada</h3>
        <?= $msgError ?>
    </div>
</section>

<section style="<?=$style?>">
    <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
    
        <section class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="dataentrada">Data</label>
                    <input class="form-control" type="date" name="dataentrada" id="dataentrada" value="<?= $dataEntrada ?>" readonly required />
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
                        <?= $categoriaController->renderizeSelectOptions(ENTRADA) ?>
                    </select>
                </div>
    
                <div class="form-group">
                    <label for="descricao">Descrição</label>
                    <input class="form-control" type="text" name="descricao" id="descricao" required />
                </div>
    
                <input type="hidden" name="idusuario" id="idusuario" value="<?= $usuario->getIdUsuario() ?>" required />
                <input type="hidden" name="idinstituicao" id="idinstituicao" value="<?= $idInstituicao ?>" required />
    
                <input class="btn btn-primary" type="submit" value="Salvar" />
    
            </div>
        </section>
    </form>
</section>