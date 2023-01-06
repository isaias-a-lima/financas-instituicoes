<?php
namespace app\model\entities\converter;

interface ConverterInterface {
    public function assocArrayToObject(array $result);
    public function arrayListToObjectList(array $array);
}