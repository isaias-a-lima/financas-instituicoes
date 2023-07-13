<?php
namespace app\controller;

use app\model\dao\EntradaDao;
use app\model\entities\Entrada;
use Exception;

class EntradaController {

    private EntradaDao $entradaDAO;

    public function __construct() {
        $this->entradaDAO = new EntradaDao();
    }

    public function getById(int $idEntrada) {
        try {
            return $this->entradaDAO->getById($idEntrada);
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
                        <th>Data</th><th>Categoria</th><th>Descrição</th><th>Valor (R$)</th><th>&nbsp;</th>
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
                    <td>$valorFomatado</td>
                    <td><span class='glyphicon glyphicon-edit'></span></td>
                </tr>
                ";
            }

            $somaFormatada = number_format($soma,2,",",".");

            $html .= "
                </tbody>
                <tfoot>
                    <tr>
                        <th>&nbsp;</th><th>&nbsp;</th><th class='text-right'>TOTAL</th><th>$somaFormatada</th><th>&nbsp;</th>
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
            if (!isset($entrada)) {
                throw new Exception("Entrada é obrigatório.");
            }

            $result = $this->entradaDAO->saveEntrada($entrada);

            if (isset($result) && $result !== false) {
                $codPage = RenderController::PAGES['LISTAR_ENTRADAS']['cod'];
                $msg = "Entrada cadastrada com sucesso.";
                echo "<script>location.replace('./?p=$codPage&msg=$msg');</script>";                
            }

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function updateEntrada(Entrada $entrada) {
        try {
            if (!isset($entrada)) {
                throw new Exception("Entrada é obrigatório.");
            }

            $result = $this->entradaDAO->updateEntrada($entrada);

            if (isset($result) && $result !== false) {
                $codPage = RenderController::PAGES['LISTAR_ENTRADAS']['cod'];
                $msg = "Entrada cadastrada com sucesso.";
                echo "<script>location.replace('./?p=$codPage&msg=$msg');</script>";                
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

}
?>