<?php
namespace app\model\entities;

class Instituicao {
    private int $idInstituicao;
    private string $cnpj;
    private string $nome;
    private string $email;
    private string $emailContab;
    private string $dataCadastro;
    private int $idUsuarioResp;

    public function getIdInstituicao() { return $this->idInstituicao; }
    public function getCnpj() { return $this->cnpj; }
    public function getNome() { return $this->nome; }
    public function getEmail() { return $this->email; }
    public function getEmailContab() { return $this->emailContab; }
    public function getDataCadastro() { return $this->dataCadastro; }
    public function getIdUsuarioResp() { return $this->idUsuarioResp; }
    
    public function setIdInstituicao(int $idInstituicao) { $this->idInstituicao = $idInstituicao; }
    public function setCnpj(string $cnpj) { $this->cnpj = $cnpj; }
    public function setNome(string $nome) { $this->nome = $nome; }
    public function setEmail(string $email) { $this->email = $email; }
    public function setEmailContab(string $emailContab) { $this->emailContab = $emailContab; }
    public function setDataCadastro(string $dataCadastro) { $this->dataCadastro = $dataCadastro; }
    public function setIdUsuarioResp(int $idUsuarioResp) { $this->idUsuarioResp = $idUsuarioResp; }
}