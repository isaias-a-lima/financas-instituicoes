<?php
namespace app\controller;

use app\lib\Constantes;
use app\lib\Validacoes;
use app\model\dao\EntradaDao;
use app\model\entities\Entrada;
use Exception;

class EntradaController {

    

    private EntradaDao $entradaDAO;
    private FechamentoController $fechamentoController;

    public function __construct() {
        $this->entradaDAO = new EntradaDao();
        $this->fechamentoController = new FechamentoController();
    }

    public function getById(int $idEntrada):Entrada {
        try {
            return $this->entradaDAO->getById($idEntrada);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function getByInstituicao(int $idInstituicao, string $dataInicio, string $dataFim, bool $exibirBotaoEditar) {
        
        $html = "";

        if ($exibirBotaoEditar) {
            $html = "
            <div class='table-responsive'>
                <table class='table table-hover'>
                    <thead>
                        <tr>
                            <th style='width: 10%;'>Data</th>
                            <th style='width: 33%;'>Categoria</th>
                            <th style='width: 33%;'>Descrição</th>
                            <th style='text-align:right; width: 15%;'>Valor (R$)</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
            ";
        } else {
            $html = "
            <div class='table-responsive'>
                <table class='table table-hover'>
                    <thead>
                        <tr>
                            <th style='width: 10%;'>Data</th>
                            <th style='width: 35%;'>Categoria</th>
                            <th style='width: 35%;'>Descrição</th>
                            <th style='text-align:right; width: 20%;'>Valor (R$)</th>
                        </tr>
                    </thead>
                    <tbody>
            ";
        }

        $soma = 0.0;
        $codPage = RenderController::PAGES['EDITAR_ENTRADA']['cod'];
        $botaoEditarHTML = "";        
        $thVazia = $exibirBotaoEditar ? "<th>&nbsp;</th>" : "";

        try {
            
            $result =  $this->entradaDAO->getByInstituicao($idInstituicao, $dataInicio, $dataFim);           

            for($i=0; $i < count($result); $i++) {
                $idEntrada = $result[$i]->getIdEntrada();
                $dataEntrada = $result[$i]->getDataEntrada();
                $dataFormatada = date("d/m/Y", strtotime($dataEntrada));
                $categoria = $result[$i]->getCategoria()->getDescricao();
                $descricao = $result[$i]->getDescricao();
                $valor = floatval($result[$i]->getValor());
                $valorFomatado = number_format($valor,2,",",".");
                $soma += $valor;

                if ($exibirBotaoEditar) {
                    $botaoEditarHTML = "<td style='text-align:right;'><a href='./?p=$codPage&ide=$idEntrada' title='Editar' alt='Editar'><span class='glyphicon glyphicon-edit'></span> Editar</a></td>";
                } else {
                    $botaoEditarHTML = "";
                }

                $html .= "
                <tr>
                    <td>$dataFormatada</td>
                    <td>$categoria</td>
                    <td>$descricao</td>
                    <td style='text-align:right;'>$valorFomatado</td>
                    $botaoEditarHTML
                </tr>
                ";
            }

            $somaFormatada = number_format($soma,2,",",".");

            $html .= "
                </tbody>
                <tfoot>
                    <tr>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th style='text-align:right;'>TOTAL &nbsp; $somaFormatada</th>
                        $thVazia
                    </tr>
                </tfoot>
            </table>
        </div>
            ";

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return $html;
    }

    public function saveEntrada(Entrada $entrada) {
        try {
            Validacoes::validParamAndRiseMessage($entrada, "Entrada é obrigatório.");

            $idi = $entrada->getInstituicao()->getIdInstituicao();

            $hasFechamento = $this->fechamentoController->hasFechamento($idi, date("Y-m-d"));

            Validacoes::isTrueThenRiseMessage($hasFechamento, Constantes::CAN_NOT_SAVE_ENTRADA);

            $result = $this->entradaDAO->saveEntrada($entrada);

            if (isset($result) && $result !== false) {
                $codPage = RenderController::PAGES['LISTAR_ENTRADAS']['cod'];
                $msg = "Entrada cadastrada com sucesso.";
                echo "<script>location.replace('./?p=$codPage&idi=$idi&msg=$msg');</script>";                
            }

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function updateEntrada(Entrada $entrada) {
        try {            
            Validacoes::validParamAndRiseMessage($entrada, "Entrada é obrigatório.");

            $idInstituicao = $entrada->getInstituicao()->getIdInstituicao();

            $hasFechamento = $this->fechamentoController->hasFechamento($idInstituicao, date("Y-m-d", strtotime($entrada->getDataEntrada())));
            
            Validacoes::isTrueThenRiseMessage($hasFechamento, Constantes::CAN_NOT_UPDATE_ENTRADA);

            $result = $this->entradaDAO->updateEntrada($entrada);

            if (isset($result)) {
                $codPage = RenderController::PAGES['LISTAR_ENTRADAS']['cod'];                
                $msg = "Entrada alterada com sucesso.";
                echo "<script>location.replace('./?p=$codPage&idi=$idInstituicao&msg=$msg');</script>";                
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function getSomaById(int $idInstituicao, string $dataInicio, string $dataFim) {
        Validacoes::validParam($idInstituicao, "ID instituição");
        Validacoes::validParam($dataInicio, "Data início");
        Validacoes::validParam($dataFim, "Data fim");
        return $this->entradaDAO->getSomaById($idInstituicao, $dataInicio, $dataFim);
    }

    public function getByInstituicaoForPDF(int $idInstituicao, string $dataInicio, string $dataFim) {
        
        $html = "
            <table class='pdf-table'>
                <thead>
                    <tr>
                        <th style='width: 10%;'>Data</th>
                        <th style='width: 35%;'>Categoria</th>
                        <th style='width: 35%;'>Descrição</th>
                        <th style='text-align:right; width: 20%;'>Valor (R$)</th>
                    </tr>
                </thead>
                <tbody>            
            ";

        $soma = 0.0;

        try {
            
            $result =  $this->entradaDAO->getByInstituicao($idInstituicao, $dataInicio, $dataFim);           

            for($i=0; $i < count($result); $i++) {
                $idEntrada = $result[$i]->getIdEntrada();
                $dataEntrada = $result[$i]->getDataEntrada();
                $dataFormatada = date("d/m/Y", strtotime($dataEntrada));
                $categoria = $result[$i]->getCategoria()->getDescricao();
                $descricao = $result[$i]->getDescricao();
                $valor = floatval($result[$i]->getValor());
                $valorFomatado = number_format($valor,2,",",".");
                $soma += $valor;

                $html .= "
                <tr>
                    <td>$dataFormatada</td>
                    <td>$categoria</td>
                    <td>$descricao</td>
                    <td style='text-align:right;'>$valorFomatado</td>
                </tr>
                ";
            }

            $somaFormatada = number_format($soma,2,",",".");

            $html .= "
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan='3' style='text-align:right;'>TOTAL</th>
                        <th style='text-align:right;'>$somaFormatada</th>
                    </tr>
                </tfoot>
            </table>
            ";

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return $html;
    }

}
?>