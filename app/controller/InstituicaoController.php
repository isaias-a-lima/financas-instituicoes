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

    public function updateInstituicao(Instituicao $instituicao) {
        try {
            if(!isset($instituicao)) {
                throw new Exception("Instituição é obrigatória.");
            }

            $result = $this->instituicaoDao->updateInstituicao($instituicao);

            if (isset($result) && $result !== false) {
                $codPage = RenderController::PAGES['HOME']['cod'];
                $msg = "Dados alterados com sucesso.";
                echo "<script>location.replace('./?p=$codPage&msg=$msg');</script>";
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function getById($idInstituicao) : Instituicao {
        try {
            $instituicao = $this->instituicaoDao->getById($idInstituicao);
            return $instituicao;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function renderizeAllInstituicoes($idUsuario) {
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

            $result = $this->instituicaoDao->getAllInstituicoes($idUsuario);

            $pEditar = RenderController::PAGES['EDITAR_INSTITUICAO']['cod'];

            $infoEditar = "Editar dados da instituição";
            $infoAddUser = "Adicionar usuários à instituição";

            for ($i=0; $i < count($result); $i++) {
                $idInstituicao = $result[$i]->getIdInstituicao();
                $nome = $result[$i]->getNome();
                $cnpj = $result[$i]->getCnpj();
                $idTitular = $result[$i]->getTitular()->getIdUsuario();
                $isTitular = $idUsuario == $idTitular;
                $cssDisplay = $isTitular ? "inline" : "none";
                $html .= "
                <tr>
                    <td>$nome</td>
                    <td>$cnpj</td>
                    <td>
                        <a href='#' style='display:$cssDisplay' title='$infoAddUser' alt='$infoAddUser'><span class='glyphicon glyphicon-user'></span></a>
                        &nbsp;
                        <a href='./?p=$pEditar&id=$idInstituicao' style='display:$cssDisplay' title='$infoEditar' alt='$infoEditar'><span class='glyphicon glyphicon-edit'></span></a>                        
                    </td>
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