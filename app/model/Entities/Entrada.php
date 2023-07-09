<?php
namespace app\model\entities;

use app\model\entities\Instituicao;
use app\model\entities\Usuario;
use app\model\entities\Categoria;

class Entrada {
    private int $idEntrada;
    private Instituicao $instituicao;
    private Usuario $usuario;
    private Categoria $categoria;
    private string $dataEntrada;
    private string $descricao;
    private float $valor;

    public function getIdEntrada() {
        return $this->idEntrada;
    }

    public function setIdEntrada(int $idEntrada) {
        $this->idEntrada = $idEntrada;
    }

    public function getInstituicao() {
        return $this->instituicao;
    }

    public function setInstituicao(Instituicao $instituicao) {
        $this->instituicao = $instituicao;
    }

    public function getUsuario() {
        return $this->usuario;
    }

    public function setUsuario(Usuario $usuario) {
        $this->usuario = $usuario;
    }

    public function getCategoria() {
        return $this->categoria;
    }

    public function setCategoria(Categoria $categoria) {
        $this->categoria = $categoria;
    }

    public function getDataEntrada() {
        return $this->dataEntrada;
    }

    public function setDataEntrada(string $dataEntrada) {
        $this->dataEntrada = $dataEntrada;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setDescricao(string $descricao) {
        $this->descricao = $descricao;
    }

    public function getValor() {
        return $this->valor;
    }

    public function setValor(float $valor) {
        $this->valor = $valor;
    }
}
?>