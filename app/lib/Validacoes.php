<?php
namespace app\lib;

use Exception;

class Validacoes {
    public static function validParam($param, string $paramName) {
        if (!isset($param)) {
            if (!isset($paramName)) {
                $msg = "Parâmetro " . $paramName . " inválido.";
                throw new Exception($msg);
            }
            throw new Exception("Parâmetro inválido.");
        }
    }
}
?>