<?php
namespace app\controller;

use app\model\dao\CategoriaDAO;
use Exception;

class CategoriaController {

    private CategoriaDAO $categoriaDAO;

    public function __construct() {
        $this->categoriaDAO = new CategoriaDAO();
    }

    public function getByTipo(string $tipo) {
        try {
            return $this->categoriaDAO->getByTipo($tipo);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function renderizeSelectOptions(string $tipo) {
        $html = '';

        try {
            $result = $this->getByTipo($tipo);

            for ($i=0; $i < count($result); $i++) {
                $idCategoria = $result[$i]->getIdCategoria();
                $descricao = $result[$i]->getDescricao();
                $tipo = $result[$i]->getTipo();
                $html .= '<option value="'.$idCategoria.'">'. $descricao .'</option>';
            }

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return $html;
    }

}
?>