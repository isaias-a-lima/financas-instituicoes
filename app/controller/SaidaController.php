<?php
namespace app\controller;

use app\lib\Constantes;
use app\lib\Validacoes;
use app\model\dao\SaidaDao;
use app\model\entities\Saida;
use Exception;

class SaidaController {

    private SaidaDao $saidaDAO;
    private FechamentoController $fechamentoController;

    public function __construct() {
        $this->saidaDAO = new SaidaDao();
        $this->fechamentoController = new FechamentoController();
    }

    public function getById(int $idSaida):Saida {
        try {
            return $this->saidaDAO->getById($idSaida);
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
        $codPage = RenderController::PAGES['EDITAR_SAIDA']['cod'];
        $botaoEditarHTML = "";
        $thVazia = $exibirBotaoEditar ? "<th>&nbsp;</th>" : "";

        try {
            
            $result =  $this->saidaDAO->getByInstituicao($idInstituicao, $dataInicio, $dataFim);           

            for($i=0; $i < count($result); $i++) {
                $idSaida = $result[$i]->getIdSaida();
                $dataSaida = $result[$i]->getDataSaida();
                $dataFormatada = date("d/m/Y", strtotime($dataSaida));
                $categoria = $result[$i]->getCategoria()->getDescricao();
                $descricao = $result[$i]->getDescricao();
                $valor = floatval($result[$i]->getValor());
                $valorFomatado = number_format($valor,2,",",".");
                $soma += $valor;

                if ($exibirBotaoEditar) {
                    $botaoEditarHTML = "<td style='text-align:right;'><a href='./?p=$codPage&ids=$idSaida' title='Editar' alt='Editar'><span class='glyphicon glyphicon-edit'></span> Editar</a></td>";
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

    public function saveSaida(Saida $saida) {
        try {
            Validacoes::validParamAndRiseMessage($saida, "Saída é obrigatório.");

            $idi = $saida->getInstituicao()->getIdInstituicao();

            $hasFechamento = $this->fechamentoController->hasFechamento($idi, date("Y-m-d", strtotime($saida->getDataSaida())));

            Validacoes::isTrueThenRiseMessage($hasFechamento, Constantes::CAN_NOT_SAVE_MOVIMENTACOES);

            $result = $this->saidaDAO->saveSaida($saida);

            if (isset($result) && $result !== false) {
                $codPage = RenderController::PAGES['LISTAR_SAIDAS']['cod'];
                $msg = "Saída cadastrada com sucesso.";
                echo "<script>location.replace('./?p=$codPage&idi=$idi&msg=$msg');</script>";                
            }

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function updateSaida(Saida $saida) {
        try {            
            Validacoes::validParamAndRiseMessage($saida, "Saída é obrigatório.");

            $idInstituicao = $saida->getInstituicao()->getIdInstituicao();

            $hasFechamento = $this->fechamentoController->hasFechamento($idInstituicao, date("Y-m-d", strtotime($saida->getDataSaida())));
            
            Validacoes::isTrueThenRiseMessage($hasFechamento, Constantes::CAN_NOT_SAVE_MOVIMENTACOES);

            $result = $this->saidaDAO->updateSaida($saida);

            if (isset($result)) {
                $codPage = RenderController::PAGES['LISTAR_SAIDAS']['cod'];                
                $msg = "Saída alterada com sucesso.";
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
        return $this->saidaDAO->getSomaById($idInstituicao, $dataInicio, $dataFim);
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
            
            $result =  $this->saidaDAO->getByInstituicao($idInstituicao, $dataInicio, $dataFim);           

            for($i=0; $i < count($result); $i++) {
                $idSaida = $result[$i]->getIdSaida();
                $dataSaida = $result[$i]->getDataSaida();
                $dataFormatada = date("d/m/Y", strtotime($dataSaida));
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