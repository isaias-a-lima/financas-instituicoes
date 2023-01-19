<?php
namespace app\model\entities\converter;

use app\lib\Constantes;

require_once Constantes::DEFAULT_MODEL_DIR . "/entities/Instituicao.php";
require_once Constantes::DEFAULT_MODEL_DIR . "/entities/converter/ConverterInterface.php";

use app\model\entities\Instituicao;

class InstituicaoConverter implements ConverterInterface {
    
    public function assocArrayToObject(array $array) {
        if (isset($array)) {
            $instituicao = new Instituicao();
            if (isset($array['idinstituicao'])) {
                $instituicao->setIdInstituicao($array['idinstituicao']);
            }
            $instituicao->setCnpj($array['cnpj']);
            $instituicao->setNome($array['nome']);
            $instituicao->setEmail($array['email']);
            if (isset($array['emailcontab'])) {
                $instituicao->setEmailContab($array['emailcontab']);
            }
            $instituicao->setDataCadastro($array['datacadastro']);
            $instituicao->setIdUsuarioResp($array['idusuarioresp']);
            return $instituicao;
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