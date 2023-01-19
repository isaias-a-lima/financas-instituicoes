<?php
namespace app\controller;

use app\model\dao\InstituicaoDao;
use app\model\entities\Instituicao;
use Exception;

class InstituicaoController {

    private InstituicaoDao $instituicaoDao;

    public function __construct() {
        $this->instituicaoDao = new InstituicaoDao();
    }

    public function saveInstituicao(Instituicao $instituicao) {
        
        try {
            if (!isset($instituicao)) {
                throw new Exception("Instituicao é obrigatório.");
            }

            $result = $this->instituicaoDao->saveInstituicao($instituicao);

            if (isset($result) && $result !== false) {
                $codPage = RenderController::PAGES['HOME']['cod'];
                $msg = "Instituição cadastrada com sucesso.";
                header("Location:./?p=$codPage&msg=$msg");
            }

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function renderizeAllInstituicoes($idUsuarioResp) {
        $html = "
        <table class='table table-hover table-responsive'>
        <thead>
            <tr>
                <th>Instituição</th>
                <th>CNPJ</th>
                <th>E-mail</th>
                <th>E-mail contador</th>
                <th>Data cadastro</th>
            </tr>
        </thead>
        <tbody>
        ";
        try {

            $result = $this->instituicaoDao->getAllInstituicoes($idUsuarioResp);

            for ($i=0; $i < count($result); $i++) {
                $nome = $result[$i]->getNome();
                $cnpj = $result[$i]->getCnpj();
                $email = $result[$i]->getEmail();
                $emailContab = $result[$i]->getEmailContab();
                $dataCadastro = $result[$i]->getDataCadastro();
                $html .= "
                <tr>
                    <td>$nome</td>
                    <td>$cnpj</td>
                    <td>$email</td>
                    <td>$emailContab</td>
                    <td>$dataCadastro</td>
                </tr>
                ";
            }
            

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        } finally {

            $html .= "
            </tbody>
            </table>
            ";
        }

        return $html;
    }

}