<?php
namespace app\model\entities\converter;

use app\lib\Constantes;

require_once Constantes::DEFAULT_MODEL_DIR . "/entities/Usuario.php";
require_once Constantes::DEFAULT_MODEL_DIR . "/entities/converter/ConverterInterface.php";

use app\model\entities\Usuario;

class UsuarioConverter implements ConverterInterface {
    
    public function assocArrayToObject(array $array) {
        if (isset($array)) {
            $usuario = new Usuario();
            $usuario->setIdUsuario($array['idusuario']);
            $usuario->setRg($array['rg']);
            $usuario->setNome($array['nome']);
            $usuario->setEmail($array['email']);
            if (isset($array['datacadastro'])) {
                $usuario->setDataCadastro($array['datacadastro']);
            }
            if (isset($array['senha'])) {
                $usuario->setSenha($array['senha']);
            }
            if (isset($array['idinstituicao'])) {
                $usuario->setIdInstituicao($array['idinstituicao']);
            }
            if (isset($array['funcao'])) {
                $usuario->setFuncao($array['funcao']);
            }
            //TODO
            $usuario->setInstituicoes([]);
            return $usuario;
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