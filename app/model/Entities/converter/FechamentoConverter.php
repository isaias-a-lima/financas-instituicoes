<?php
namespace app\model\entities\converter;

use app\model\entities\Fechamento;

class FechamentoConverter implements ConverterInterface {

    public function assocArrayToObject(array $result) {
        if (isset($result)) {

            $fechamento = new Fechamento();

            if (isset($result['idfechamento'])) {
                $fechamento->setIdFechamento($result['idfechamento']);
            }
            $fechamento->setIdInstituicao($result['idinstituicao']);
            $fechamento->setDataInicio($result['dataInicio']);
            $fechamento->setDataFim($result['dataFim']);
            $fechamento->setSaldoInicial($result['saldoInicial']);
            $fechamento->setEntradas($result['entradas']);
            $fechamento->setSaidas($result['saidas']);

            return $fechamento;
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