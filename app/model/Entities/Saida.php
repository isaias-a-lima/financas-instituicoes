<?php
namespace app\model\entities;

use app\model\entities\Instituicao;
use app\model\entities\Usuario;
use app\model\entities\Categoria;

class Saida {
    private int $idSaida;
    private Instituicao $instituicao;
    private Usuario $usuario;
    private Categoria $categoria;
    private string $dataSaida;
    private string $descricao;
    private float $valor;
    private string $numdoc;

    public function __construct() {
        $this->numdoc = "";
    }

    public function getIdSaida() {
        return $this->idSaida;
    }

    public function setIdSaida(int $idSaida) {
        $this->idSaida = $idSaida;
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

    public function getDataSaida() {
        return $this->dataSaida;
    }

    public function setDataSaida(string $dataSaida) {
        $this->dataSaida = $dataSaida;
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

    public function setNumDoc(string $numdoc) {
        $this->numdoc = $numdoc;
    }

    public function getNumDoc() {
        return $this->numdoc;
    }
}
?>