<?php
namespace app\controller;

use app\lib\Validacoes;
use app\model\dao\FechamentoDAO;
use Exception;

class FechamentoController {

    private FechamentoDAO $fechamentoDAO;

    public function __construct() {
        $this->fechamentoDAO = new FechamentoDAO();
    }    

    public function hasFechamento(int $idInstituicao,string $dataAtual):bool {
        $result = false;
        try {
            Validacoes::validParam($idInstituicao, "ID Instituição");
            Validacoes:: validParam($dataAtual, "Data atual");
            $result = $this->fechamentoDAO->hasFechamento($idInstituicao, $dataAtual);
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
                $instituicao = $result[$i]->getInstituicao();
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
                    <td style='width:100px;'><a href='./?p=$codPage&ide=$idFechamento' title='Editar' alt='Editar'><span class='glyphicon glyphicon-edit'></span> Editar</a></td>
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
    
}
?>