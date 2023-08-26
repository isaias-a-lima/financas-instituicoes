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
    
}
?>