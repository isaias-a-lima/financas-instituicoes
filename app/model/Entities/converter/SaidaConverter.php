<?php
namespace app\model\entities\converter;

use app\model\entities\Categoria;
use app\model\entities\Saida;
use app\model\entities\Instituicao;
use app\model\entities\Usuario;
use Exception;

class SaidaConverter implements ConverterInterface {

    public function assocArrayToObject(array $result) {
        if (isset($result)) {
            try {
                $titularInstituicao = new Usuario();
                $titularInstituicao->setIdUsuario($result['idtitular']);
                $titularInstituicao->setRg($result['rgtitular']);
                $titularInstituicao->setNome($result['nometitular']);
                $titularInstituicao->setEmail($result['emailtitular']);
                $titularInstituicao->setDataCadastro($result['datacadastrotitular']);
    
                $instituicao = new Instituicao();
                $instituicao->setIdInstituicao($result['idinstituicao']);
                $instituicao->setCnpj($result['cnpj']);
                $instituicao->setNome($result['nome_instituicao']);
                $instituicao->setEmail($result['email_instituicao']);
                $instituicao->setEmailContab($result['emailcontab']);
                $instituicao->setDataCadastro($result['data_cadastro_instituicao']);
                $instituicao->setTitular($titularInstituicao);
                
                $usuario = new Usuario();
                $usuario->setIdUsuario($result['idusuario']);
                $usuario->setRg($result['rg']);
                $usuario->setNome($result['nome_user']);
                $usuario->setEmail($result['email_user']);
                $usuario->setDataCadastro($result['data_cadastro_user']);            
    
                $categoria = new Categoria();
                $categoria->setIdCategoria($result['idcategoria']);
                $categoria->setDescricao($result['desc_categoria']);
                $categoria->setTipo($result['tipo']);
    
                $saida = new Saida();
                if (isset($result['idsaida'])) {
                    $saida->setIdSaida($result['idsaida']);
                }
                $saida->setDataSaida($result['datasaida']);
                if(isset($result['desc_saida'])) {
                    $saida->setDescricao($result['desc_saida']);
                }
                $saida->setValor($result['valor']);
                $saida->setInstituicao($instituicao);
                $saida->setUsuario($usuario);
                $saida->setCategoria($categoria);
                if(isset($result['numdoc'])) {
                    $saida->setNumDoc($result['numdoc']);
                }
    
                return $saida;
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
            
        }
        return null;
    }

    public function arrayListToObjectList(array $array) {
        $objects = [];
        if (isset($array) && count($array) > 0) {
            foreach($array as $x) {               
               array_push($objects, self::assocArrayToObject($x));
            }
        }
        return $objects;
    }

}
?>