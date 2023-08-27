<?php
namespace app\model\entities\converter;

use app\model\entities\Fechamento;
use app\model\entities\Instituicao;
use app\model\entities\Usuario;

class FechamentoConverter implements ConverterInterface {

    public function assocArrayToObject(array $result) {
        if (isset($result)) {

            $fechamento = new Fechamento();

            if (isset($result['idfechamento'])) {
                $fechamento->setIdFechamento($result['idfechamento']);
            }

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

            $fechamento->setInstituicao($instituicao);
            $fechamento->setDataInicio($result['datainicio']);
            $fechamento->setDataFim($result['datafim']);
            $fechamento->setSaldoInicial($result['saldoinicial']);
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