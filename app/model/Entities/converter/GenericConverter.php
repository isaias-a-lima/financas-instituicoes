<?php
namespace app\model\entities\converter;

class GenericConverter implements ConverterInterface {

    public function assocArrayToObject(array $result) {
        $valor = null;

        if (isset($result)) {
            if (isset($result['coluna'])) {
               $valor = $result['coluna'];
            }

            return $valor;
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