<?php

use app\controller\CategoriaController;
use app\controller\SaidaController;
use app\controller\FechamentoController;
use app\controller\RenderController;
use app\lib\Constantes;
use app\lib\Validacoes;
use app\model\entities\Categoria;
use app\model\entities\Saida;
use app\model\entities\Instituicao;
use app\model\entities\Usuario;

$msg = "";
$msgError = "";
const SAIDA = "S";
$hasFechamento = false;
$numDoc = "";
$style = "";

try {
    $saida = null;
    $instituicao = new Instituicao();
    $user = new Usuario();
    $categoria = new Categoria();
    $controller = new SaidaController();
    $categoriaController = new CategoriaController();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $saida = new Saida();
        
        Validacoes::validParam($_POST['idsaida'], "ID Saída");
        Validacoes::validParam($_POST['idinstituicao'], "ID Instituição");

        $instituicao->setIdInstituicao($_POST['idinstituicao']);
        $instituicao->setNome($_POST['nomeinstituicao']);
        $saida->setInstituicao($instituicao);

        $saida->setIdSaida($_POST['idsaida']);
        
        $user->setIdUsuario(isset($_POST['idusuario']) ? $_POST['idusuario'] : null);
        $saida->setUsuario($user);
        
        $categoria->setIdCategoria(isset($_POST['idcategoria']) ? $_POST['idcategoria'] : null);
        $saida->setCategoria($categoria);

        $saida->setDescricao(isset($_POST['descricao']) ? $_POST['descricao'] : null);
        $saida->setValor(isset($_POST['valor']) ? $_POST['valor'] : null);
        $saida->setNumDoc(isset($_POST['numdoc']) ? $_POST['numdoc'] : null);
        
        $controller->updateSaida($saida);
    } else {
        $idSaida = isset($_GET['ide']) ? $_GET['ide'] : 0;
        if ($idSaida == 0) {
            throw new Exception("ID de saida inválido.");
        }

        $saida = $controller->getById($idSaida);       

        $fechamentoController = new FechamentoController();
        $hasFechamento = $fechamentoController->hasFechamento($saida->getInstituicao()->getIdInstituicao(), date("Y-m-d"));
        Validacoes::isTrueThenRiseMessage($hasFechamento, Constantes::CAN_NOT_UPDATE_SAIDA);
    }
} catch (Exception $e) {
    $msg = $e->getMessage();
    $msgError = "<div class='alert alert-danger'>$msg</div>";
    $style = $hasFechamento == true ? "display: none;" : "";

    $idSaida = isset($_GET['ide']) ? $_GET['ide'] : 0;
    if ($idSaida == 0) {
        throw new Exception("ID de saida inválido.");
    }

    $saida = $controller->getById($idSaida);
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
                <a href="./?p=<?= RenderController::PAGES['DASHBOARD_INSTITUICAO']['cod'] ?>&idi=<?= $saida->getInstituicao()->getIdInstituicao();?>">
                    Painel
                </a>
            </li>
            <li>
                <a href="./?p=<?= RenderController::PAGES['LISTAR_SAIDAS']['cod'] ?>&idi=<?= $saida->getInstituicao()->getIdInstituicao();?>">
                    Saídas
                </a>
            </li>
            <li class="active">Editar Saída</li>
        </ol>
    </div>
</section>

<h2><?=$saida->getInstituicao()->getNome()?></h2>

<section class="row">
    <div class="col-md-12">
        <h3>Editar Saída</h3>
        <?php echo $msgError; ?>
    </div>
</section>

<section style="<?=$style?>">
    <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
    
        <section class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="datasaida">Data</label>
                    <input class="form-control" type="date" name="datasaida" id="datasaida" value="<?=$saida->getDataSaida()?>" readonly required />
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="valor">Valor</label>
                    <input class="form-control" type="number" name="valor" id="valor" min="0" step="0.01" value="<?=$saida->getValor();?>" required />
                </div>
            </div>
        </section>
    
        <section class="row">
            <div class="col-md-6">
    
                <div class="form-group">
                    <label for="categoria">Categoria</label>
                    <select class="form-control" name="idcategoria" id="idcategoria" required>
                        <option value="<?=$saida->getCategoria()->getIdCategoria();?>"><?=$saida->getCategoria()->getDescricao();?></option>
                        <?=$categoriaController->renderizeSelectOptions(SAIDA)?>
                    </select>
                </div>
    
                <div class="form-group">
                    <label for="descricao">Descrição</label>
                    <input class="form-control" type="text" name="descricao" id="descricao" value="<?=$saida->getDescricao()?>" required />
                </div>

                <div class="form-group">
                    <label for="numdoc">Número do Documento</label>
                    <input class="form-control" type="text" name="numdoc" id="numdoc" value="<?=$saida->getNumDoc()?>" />
                </div>
    
                <input type="hidden" name="idusuario" id="idusuario" value="<?=$usuario->getIdUsuario()?>" />
                <input type="hidden" name="idsaida" id="idsaida" value="<?=$saida->getIdSaida()?>" />
                <input type="hidden" name="idinstituicao" id="idinstituicao" value="<?=$saida->getInstituicao()->getIdInstituicao()?>" />
                <input type="hidden" name="nomeinstituicao" id="nomeinstituicao" value="<?=$saida->getInstituicao()->getNome()?>" />
    
                <input class="btn btn-primary" type="submit" value="Salvar" />
    
            </div>
        </section>
    </form>
</section>