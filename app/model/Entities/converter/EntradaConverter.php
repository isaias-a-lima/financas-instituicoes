<?php
namespace app\model\entities\converter;

use app\model\entities\Categoria;
use app\model\entities\Entrada;
use app\model\entities\Instituicao;
use app\model\entities\Usuario;

class EntradaConverter implements ConverterInterface {

    public function assocArrayToObject(array $result) {
        if (isset($result)) {
            $instituicao = new Instituicao();
            $instituicao->setIdInstituicao($result['idinstituicao']);
            
            $usuario = new Usuario();
            $usuario->setIdUsuario($result['idusuario']);
            $usuario->setNome($result['nome_user']);
            $usuario->setEmail($result['email_user']);

            $categoria = new Categoria();
            $categoria->setIdCategoria($result['idcategoria']);
            $categoria->setDescricao($result['desc_categoria']);
            $categoria->setTipo($result['tipo']);

            $entrada = new Entrada();
            if (isset($result['identrada'])) {
                $entrada->setIdEntrada($result['identrada']);
            }
            $entrada->setDataEntrada($result['dataentrada']);
            $entrada->setDescricao($result['descricao']);
            $entrada->setValor($result['valor']);
            $entrada->setInstituicao($instituicao);
            $entrada->setUsuario($usuario);
            $entrada->setCategoria($categoria);

            return $entrada;
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