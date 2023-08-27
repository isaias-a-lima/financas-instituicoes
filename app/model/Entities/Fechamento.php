<?php
namespace app\model\entities;

use app\lib\Validacoes;

class Fechamento {

    private int $idFechamento;
    private Instituicao $instituicao;
    private string $dataInicio;
    private string $dataFim;
    private float $saldoInicial;
    private float $entradas;
    private float $saidas;

    public function setIdFechamento(int $idFechamento) { $this->idFechamento = $idFechamento; }
    public function getIdFechamento():int {return $this->idFechamento; }

    public function setInstituicao(Instituicao $instituicao) { $this->instituicao = $instituicao; }
    public function getInstituicao():Instituicao {return $this->instituicao; }

    public function setDataInicio(string $dataInicio) { $this->dataInicio = $dataInicio; }
    public function getDataInicio():string {return $this->dataInicio; }

    public function setDataFim(string $dataFim) { $this->dataFim = $dataFim; }
    public function getDataFim():string {return $this->dataFim; }

    public function setSaldoInicial(float $saldoInicial) { $this->saldoInicial = $saldoInicial; }
    public function getSaldoInicial():float {return $this->saldoInicial; }

    public function setEntradas(float $entradas) { $this->entradas = $entradas; }
    public function getEntradas():float {return $this->entradas; }

    public function setSaidas(float $saidas) { $this->saidas = $saidas; }
    public function getSaidas():float {return $this->saidas; }
}
?>