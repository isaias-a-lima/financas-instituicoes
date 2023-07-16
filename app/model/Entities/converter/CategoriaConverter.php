<?php
namespace app\model\entities\converter;

use app\model\entities\Categoria;

class CategoriaConverter implements ConverterInterface {

    public function assocArrayToObject(array $result) {
        if (isset($result)) {

            $categoria = new Categoria();

            if (isset($result['idcategoria'])) {
                $categoria->setIdCategoria($result['idcategoria']);
            }
            $categoria->setDescricao($result['descricao']);
            $categoria->setTipo($result['tipo']);

            return $categoria;
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