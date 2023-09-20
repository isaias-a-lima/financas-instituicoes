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

    public function getByInstituicao(int $idInstituicao, string $dataInicio, string $dataFim) {
        $html = "
        <div class='table-responsive'>
            <table class='table table-hover'>
                <thead>
                    <tr>
                        <th>Data</th><th>Categoria</th><th>Descrição</th><th style='text-align:right;'>Valor (R$)</th><th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
        ";
        $soma = 0.0;
        $codPage = RenderController::PAGES['EDITAR_SAIDA']['cod'];

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
                    <td style='text-align:right;'><a href='./?p=$codPage&ide=$idSaida' title='Editar' alt='Editar'><span class='glyphicon glyphicon-edit'></span> Editar</a></td>
                </tr>
                ";
            }

            $somaFormatada = number_format($soma,2,",",".");

            $html .= "
                </tbody>
                <tfoot>
                    <tr>
                        <th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th style='text-align:right;'>TOTAL &nbsp; $somaFormatada</th><th>&nbsp;</th>
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

            $hasFechamento = $this->fechamentoController->hasFechamento($idi, date("Y-m-d"));

            Validacoes::isTrueThenRiseMessage($hasFechamento, Constantes::CAN_NOT_SAVE_ENTRADA);

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
            
            Validacoes::isTrueThenRiseMessage($hasFechamento, Constantes::CAN_NOT_UPDATE_SAIDA);

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

}
?>