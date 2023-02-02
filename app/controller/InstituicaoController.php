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
                echo "<script>location.replace('./?p=$codPage&msg=$msg');</script>";                
            }

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function renderizeAllInstituicoes($idUsuarioResp) {
        $html = "
            <div class='table-responsive'>
            <table class='table table-hover'>
            <thead>
                <tr>
                    <th>Instituição</th>
                    <th>CNPJ</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
        ";
        try {

            $result = $this->instituicaoDao->getAllInstituicoes($idUsuarioResp);

            for ($i=0; $i < count($result); $i++) {
                $nome = $result[$i]->getNome();
                $cnpj = $result[$i]->getCnpj();
                $html .= "
                <tr>
                    <td>$nome</td>
                    <td>$cnpj</td>
                    <td><span class='glyphicon glyphicon-edit'></span></td>
                </tr>
                ";
            }
            

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        } finally {

            $html .= "
            </tbody>
            </table>
            </div>
            ";
        }

        return $html;
    }

}