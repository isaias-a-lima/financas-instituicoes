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
                    <th>Opções</th>
                    <th>Faturas</th>
                </tr>
            </thead>
            <tbody>
        ";
        try {

            $result = $this->instituicaoDao->getAllInstituicoes($idUsuario);

            $pEditar = RenderController::PAGES['EDITAR_INSTITUICAO']['cod'];
            $pEntradas = RenderController::PAGES['LISTAR_ENTRADAS']['cod'];

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
                        <a href='./?p=$pEntradas&id=$idInstituicao' class='text-primary' title='Entradas' alt='Entradas'><span class='glyphicon glyphicon-plus-sign'></span></a>

                        <a href='#' class='text-danger' title='Saídas' alt='Saídas'><span class='glyphicon glyphicon-minus-sign'></span></a>

                        <a href='#' class='text-success' title='Relatórios' alt='Relatórios'><span class='glyphicon glyphicon-stats'></span></a>
                        
                        <a href='#' class='text-warning' title='Contas a pagar' alt='Entradas'><span class='glyphicon glyphicon-usd'></span></a>
                        
                        <a href='#' onclick='openUserModal($idInstituicao)' style='display:$cssDisplay' title='$infoAddUser' alt='$infoAddUser'><span class='glyphicon glyphicon-user'></span></a>
                        
                        <a href='./?p=$pEditar&id=$idInstituicao' style='display:$cssDisplay' title='$infoEditar' alt='$infoEditar'><span class='glyphicon glyphicon-edit'></span></a>                        
                    </td>
                    <td>
                        <a href='#' title='Faturas' alt='Faturas'><span class='glyphicon glyphicon-barcode'></span></a>
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