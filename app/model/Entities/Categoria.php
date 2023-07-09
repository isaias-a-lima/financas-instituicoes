<?php
namespace app\model\entities;

class Categoria {
    private int $idCategoria;
    private string $descricao;
    private string $tipo;

    public function getIdCategoria() {
        return $this->idCategoria;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function setIdCategoria(int $idCategoria) {
        $this->idCategoria = $idCategoria;
    }

    public function setDescricao(string $descricao) {
        $this->descricao = $descricao;
    }

    public function setTipo(string $tipo) {
        $this->tipo = $tipo;
    }
}
?>