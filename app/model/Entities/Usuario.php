<?php
namespace app\model\entities;

use DateTime;

class Usuario {

    private int $idUsuario;
    private string $rg;
    private string $nome;
    private string $email;
    private string $senha;
    private DateTime $dataCadastro;
    private array $instituicoes;

    public function getIdUsuario() { return $this->idUsuario; }
    public function getRg() { return $this->rg; }
    public function getNome() { return $this->nome; }
    public function getEmail() { return $this->email; }
    public function getSenha() { return $this->senha; }
    public function getDataCadastro() { return $this->dataCadastro; }
    public function getInstituicoes() { return $this->instituicoes; }

    public function setIdUsuario(int $idUsuario) { $this->idUsuario = $idUsuario; }
    public function setRg(string $rg) { $this->rg = $rg; }
    public function setNome(string $nome) { $this->nome = $nome; }
    public function setEmail(string $email) { $this->email = $email; }
    public function setSenha(string $senha) { $this->senha = $senha; }
    public function setDataCadastro(DateTime $dataCadastro) { $this->dataCadastro = $dataCadastro; }
    public function setInstituicoes(array $instituicoes) { $this->instituicoes = $instituicoes; }

}