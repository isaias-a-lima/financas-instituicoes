<?php
namespace app\model\entities\converter;

use app\model\entities\Categoria;
use app\model\entities\Entrada;
use app\model\entities\Instituicao;
use app\model\entities\Usuario;

class EntradaConverter implements ConverterInterface {

    public function assocArrayToObject(array $result) {
        if (isset($result)) {
            $entrada = new Entrada();

            if (isset($result['identrada'])) {
                $entrada->setIdEntrada($result['identrada']);
            }
            $instituicao = new Instituicao();
            $instituicao->setIdInstituicao($result['idinstituicao']);
            $entrada->setInstituicao($instituicao);
            $usuario = new Usuario();
            $usuario->setIdUsuario($result['idusuario']);
            $entrada->setUsuario($usuario);
            $categoria = new Categoria();
            $categoria->setIdCategoria($result['idcategoria']);
            $entrada->setCategoria($categoria);
            $entrada->setDataEntrada($result['dataentrada']);
            $entrada->setDescricao($result['descricao']);
            $entrada->setValor($result['valor']);

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