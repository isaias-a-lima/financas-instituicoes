<?php
namespace app\model\entities\converter;

class BooleanConverter implements ConverterInterface {

    public function assocArrayToObject(array $result) {
        $flag = null;

        if (isset($result)) {
            if (isset($result['chave'])) {
               $flag = $result['chave'];
            }

            return $flag;
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