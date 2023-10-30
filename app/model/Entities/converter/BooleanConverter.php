<?php
namespace app\model\entities\converter;

class BooleanConverter implements ConverterInterface {

    public function assocArrayToObject(array $result) {
        $flag = false;

        if (isset($result)) {
            if (isset($result['chave'])) {
               $flag = filter_var($result['chave'], FILTER_VALIDATE_BOOLEAN);
            }

            return $flag;
        }
        return false;
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