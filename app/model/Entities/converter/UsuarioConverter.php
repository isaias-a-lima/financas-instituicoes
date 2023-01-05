<?php
namespace app\model\entities\converter;

use app\lib\Constantes;

require_once Constantes::DEFAULT_MODEL_DIR . "/entities/Usuario.php";

use app\model\entities\Usuario;

class UsuarioConverter {
    
    public static function ArrayToUsuario(array $array) {
        if (isset($array)) {
            $usuario = new Usuario();
            $usuario->setIdUsuario($array['idusuario']);
            $usuario->setNome($array['nome']);
            $usuario->setEmail($array['email']);
            $usuario->setSenha($array['senha']);
            //TODO
            $usuario->setInstituicoes([]);
            return $usuario;
        }
        return false;
    }
}