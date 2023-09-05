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
                $codPage = RenderController::PAGES['DASHBOARD_INSTITUICAO']['cod'];
                $idInstituicao = $instituicao->getIdInstituicao();
                $msg = "Dados alterados com sucesso.";
                echo "<script>location.replace('./?p=$codPage&idi=$idInstituicao&msg=$msg');</script>";
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function saveUsuariosInstituicao(int $idUsuario, int $idInstituicao, $funcao) {
        try {
            return $this->instituicaoDao->saveUsuariosInstituicao($idUsuario, $idInstituicao, $funcao);            
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
                    <th>Nome</th>
                    <th style='width:100px;'>Opções</th>
                </tr>
            </thead>
            <tbody>
        ";
        try {

            $result = $this->instituicaoDao->getAllInstituicoes($idUsuario);

            $pEditar = RenderController::PAGES['EDITAR_INSTITUICAO']['cod'];
            $pEntradas = RenderController::PAGES['LISTAR_ENTRADAS']['cod'];
            $pPainelInstituicao = RenderController::PAGES['DASHBOARD_INSTITUICAO']['cod'];

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
                    <td>
                        <a href='./?p=$pPainelInstituicao&idi=$idInstituicao' class='btn btn-default'>
                            <span class='glyphicon glyphicon-dashboard text-danger'></span> Painel
                        </a>
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