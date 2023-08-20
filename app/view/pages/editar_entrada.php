<?php

use app\controller\CategoriaController;
use app\controller\EntradaController;
use app\controller\RenderController;
use app\exceptions\ExceptionUtil;
use app\lib\Validacoes;
use app\model\entities\Categoria;
use app\model\entities\Entrada;
use app\model\entities\Instituicao;
use app\model\entities\Usuario;

$msg = "";
$error = "";
const ENTRADA = "E";

try {
    $entrada = null;
    $instituicao = new Instituicao();
    $user = new Usuario();
    $categoria = new Categoria();
    $controller = new EntradaController();
    $categoriaController = new CategoriaController();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $entrada = new Entrada();
        
        Validacoes::validParam($_POST['identrada'], "ID Entrada");
        Validacoes::validParam($_POST['idinstituicao'], "ID Instituição");

        $instituicao->setIdInstituicao($_POST['idinstituicao']);
        $entrada->setInstituicao($instituicao);

        $entrada->setIdEntrada($_POST['identrada']);
        
        $user->setIdUsuario(isset($_POST['idusuario']) ? $_POST['idusuario'] : null);
        $entrada->setUsuario($user);
        
        $categoria->setIdCategoria(isset($_POST['idcategoria']) ? $_POST['idcategoria'] : null);
        $entrada->setCategoria($categoria);

        $entrada->setDescricao(isset($_POST['descricao']) ? $_POST['descricao'] : null);
        $entrada->setValor(isset($_POST['valor']) ? $_POST['valor'] : null);        
        
        $controller->updateEntrada($entrada);
    } else {
        $idEntrada = isset($_GET['ide']) ? $_GET['ide'] : 0;
        if ($idEntrada == 0) {
            throw new Exception("ID de entrada inválido.");
        }

        $entrada = $controller->getById($idEntrada);

    }
} catch (Exception $e) {
    $msg = $e->getMessage();
    $error = "<div class='alert alert-danger'>$msg</div>";
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
                <a href="./?p=<?= RenderController::PAGES['DASHBOARD_INSTITUICAO']['cod'] ?>&idi=<?= $entrada->getInstituicao()->getIdInstituicao();?>">
                    Dashboard
                </a>
            </li>
            <li>
                <a href="./?p=<?= RenderController::PAGES['LISTAR_ENTRADAS']['cod'] ?>&idi=<?= $entrada->getInstituicao()->getIdInstituicao();?>">
                    Entradas
                </a>
            </li>
            <li class="active">Editar Entrada</li>
        </ol>
    </div>
</section>

<h2><?=$entrada->getInstituicao()->getNome()?></h2>

<section class="row">
    <div class="col-md-12">
        <h3>Editar Entrada</h3>
        <?= $error ?>
    </div>
</section>

<form method="post" action="<?php $_SERVER['PHP_SELF'] ?>">

    <section class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="dataentrada">Data</label>
                <input class="form-control" type="date" name="dataentrada" id="dataentrada" value="<?=$entrada->getDataEntrada()?>" readonly required />
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="valor">Valor</label>
                <input class="form-control" type="number" name="valor" id="valor" min="0" step="0.01" value="<?=$entrada->getValor();?>" required />
            </div>
        </div>
    </section>

    <section class="row">
        <div class="col-md-6">

            <div class="form-group">
                <label for="categoria">Categoria</label>
                <select class="form-control" name="idcategoria" id="idcategoria" required>
                    <option value="<?=$entrada->getCategoria()->getIdCategoria();?>"><?=$entrada->getCategoria()->getDescricao();?></option>
                    <?=$categoriaController->renderizeSelectOptions(ENTRADA)?>
                </select>
            </div>

            <div class="form-group">
                <label for="descricao">Descrição</label>
                <input class="form-control" type="text" name="descricao" id="descricao" value="<?=$entrada->getDescricao()?>" required />
            </div>

            <input type="hidden" name="idusuario" id="idusuario" value="<?=$usuario->getIdUsuario()?>" />
            <input type="hidden" name="identrada" id="identrada" value="<?=$entrada->getIdEntrada()?>" />
            <input type="hidden" name="idinstituicao" id="idinstituicao" value="<?=$entrada->getInstituicao()->getIdInstituicao()?>" />

            <input class="btn btn-primary" type="submit" value="Salvar" />

        </div>
    </section>
</form>