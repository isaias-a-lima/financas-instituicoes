<?php
namespace app\model\entities;

class Usuario {

    private int $idUsuario;
    private string $rg;
    private string $nome;
    private string $email;
    private string $senha;
    private string $dataCadastro;
    private array $instituicoes;
    private int $idInstituicao;
    private string $funcao;

    public function getIdUsuario() { return $this->idUsuario; }
    public function getRg() { return $this->rg; }
    public function getNome() { return $this->nome; }
    public function getEmail() { return $this->email; }
    public function getSenha() { return $this->senha; }
    public function getDataCadastro() { return $this->dataCadastro; }
    public function getInstituicoes() { return $this->instituicoes; }
    public function getIdInstituicao() { return $this->idInstituicao; }
    public function getFuncao() { return $this->funcao; }

    public function setIdUsuario(int $idUsuario) { $this->idUsuario = $idUsuario; }
    public function setRg(string $rg) { $this->rg = $rg; }
    public function setNome(string $nome) { $this->nome = $nome; }
    public function setEmail(string $email) { $this->email = $email; }
    public function setSenha(string $senha) { $this->senha = $senha; }
    public function setDataCadastro(string $dataCadastro) { $this->dataCadastro = $dataCadastro; }
    public function setInstituicoes(array $instituicoes) { $this->instituicoes = $instituicoes; }
    public function setIdInstituicao(int $idInstituicao) { $this->idInstituicao = $idInstituicao; }
    public function setFuncao(string $funcao) { $this->funcao = $funcao; }

}