<?php
namespace app\lib;

use Exception;

class Validacoes {
    public static function validParam($param, string $paramName) {
        if (!isset($param)) {
            if (isset($paramName)) {
                $msg = "Parâmetro " . $paramName . " inválido.";
                throw new Exception($msg);
            }
            throw new Exception("Parâmetro inválido.");
        }
    }

    public static function validParamAndRiseMessage($param, string $message) {
        if (!isset($param)) {
            if (isset($message)) {
                throw new Exception($message);
            }
            throw new Exception("Parâmetro inválido.");
        }
    }

    public static function isTrueThenRiseMessage($param, string $message) {
        if (isset($param) && is_bool($param) && $param) {
            if (isset($message)) {
                throw new Exception($message);
            }
            throw new Exception("Condição verdadeira.");
        }
    }
}
?>