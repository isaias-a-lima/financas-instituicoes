<?php

class Instituicao {
    private int $idInstituicao;
    private string $cnpj;
    private string $nome;
    private string $email;
    private DateTime $dataCadastro;
    private int $idUsuarioResp;

    public function getIdInstituicao() { return $this->idInstituicao; }
    public function getCnpj() { return $this->cnpj; }
    public function getNome() { return $this->nome; }
    public function getEmail() { return $this->email; }
    public function getDataCadastro() { return $this->dataCadastro; }
    public function getIdUsuarioResp() { return $this->idUsuarioResp; }
    
    public function setIdInstituicao(int $idInstituicao) { $this->idInstituicao = $idInstituicao; }
    public function setCnpj(int $cnpj) { $this->cnpj = $cnpj; }
    public function setNome(int $nome) { $this->nome = $nome; }
    public function setEmail(int $email) { $this->email = $email; }
    public function setDataCadastro(int $dataCadastro) { $this->dataCadastro = $dataCadastro; }
    public function setIdUsuarioResp(int $idUsuarioResp) { $this->idUsuarioResp = $idUsuarioResp; }
}