<?php
namespace app\controller;

use app\lib\Constantes;
use app\lib\Validacoes;
use app\model\dao\FechamentoDAO;
use app\model\entities\Fechamento;
use Exception;

class FechamentoController {

    private FechamentoDAO $fechamentoDAO;

    public function __construct() {
        $this->fechamentoDAO = new FechamentoDAO();
    }    

    public function hasFechamento(int $idInstituicao, string $data):bool {
        $result = false;
        try {
            Validacoes::validParam($idInstituicao, "ID Instituição");
            Validacoes:: validParam($data, "Data");
            $result = $this->fechamentoDAO->hasFechamento($idInstituicao, $data);
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }
        return $result;
    }

    public function getByInstituicao(int $idInstituicao, string $ano) {
        $html = "
        <div class='table-responsive'>
            <table class='table table-hover'>
                <thead>
                    <tr>
                        <th colspan='2'>Período</th><th>Saldo Inicial</th><th>Entradas</th><th>Saídas</th><th>Saldo Final</th><th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
        ";
        $soma = 0.0;
        $codPage = RenderController::PAGES['EDITAR_FECHAMENTO']['cod'];

        try {
            
            $result =  $this->fechamentoDAO->getByInstituicao($idInstituicao, $ano);           

            for($i=0; $i < count($result); $i++) {
                $idFechamento = $result[$i]->getIdFechamento();
                $dataInicio = $result[$i]->getDataInicio();
                $dataInicioFormatada = date("d/m/Y", strtotime($dataInicio));
                $dataFim = $result[$i]->getDataFim();
                $dataFimFormatada = date("d/m/Y", strtotime($dataFim));
                $saldoInicial = number_format(floatval($result[$i]->getSaldoInicial()), 2, ",", ".");
                $entradas = number_format(floatval($result[$i]->getEntradas()), 2, ",", ".");
                $saidas = number_format(floatval($result[$i]->getSaidas()), 2, ",", ".") ;
                $saldoFinal = number_format(floatval((($result[$i]->getSaldoInicial() + $result[$i]->getEntradas()) - $result[$i]->getSaidas())), 2, ",", ".");

                $html .= "
                <tr>
                    <td>$dataInicioFormatada</td>
                    <td>$dataFimFormatada</td>
                    <td>$saldoInicial</td>
                    <td>$entradas</td>
                    <td>$saidas</td>
                    <td>$saldoFinal</td>
                    <td><!--<a href='#' title='Editar' alt='Editar'><span class='glyphicon glyphicon-edit'></span> Editar</a>-->&nbsp;</td>
                </tr>
                ";
            }

            $html .= "
                </tbody>
            </table>
        </div>
            ";

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return $html;
    }

    public function saveFechamento(Fechamento $fechamento) {
        $result = null;
        try {
            //Validações
            Validacoes::validParam($fechamento, "Fechamento");
            
            $mes = (int) date("m", strtotime($fechamento->getDataInicio()));
            Validacoes::isValidMonthForClosing($mes);
            
            $this->validHasClosing($fechamento->getInstituicao()->getIdInstituicao(), $fechamento->getDataInicio());

            $idi = $fechamento->getInstituicao()->getIdInstituicao();

            if($fechamento->getSaldoInicial() == 0 && $fechamento->getEntradas() == 0 && $fechamento->getSaidas() == 0) {
                throw new Exception(Constantes::HAS_NOT_MOVIMENTACOES);
            }
            
            //save
            $result = $this->fechamentoDAO->saveFechamento($fechamento);
            if (isset($result) && $result !== false) {
                $codPage = RenderController::PAGES['LISTAR_FECHAMENTOS']['cod'];
                $msg = "Fechamento registrado com sucesso.";
                echo "<script>location.replace('./?p=$codPage&idi=$idi&msg=$msg');</script>";                
            }

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return $result;
    }

    private function validHasClosing($idInstituicao, $data) {
        $hasFechamento = $this->hasFechamento($idInstituicao, $data);
        if($hasFechamento) {
            throw new Exception(Constantes::HAS_FECHAMENTOS);
        }
    }

    public function getFechamentoAnterior(int $idInstituicao, string $data) {
        Validacoes::validParam($idInstituicao, "ID Instituição");
        Validacoes::validParam($data, "Data");
        return $this->fechamentoDAO->getFechamentoAnterior($idInstituicao, $data);
    }
    
}
?>