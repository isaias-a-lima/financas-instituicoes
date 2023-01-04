<?php
namespace app\lib;

use Exception;

class SecurityUtil {

    public static function sanitizeString($str) {
        if (empty($str)) {
            throw new Exception("É obrigatório infomar um texto.");
        }
        $str = filter_var($str, FILTER_SANITIZE_SPECIAL_CHARS);
        return $str;
    }

    public static function sanitizeInteger($number) {
        if (empty($number)) {
            throw new Exception("É obrigatório infomar um número.");
        }
        $number = filter_var($number, FILTER_SANITIZE_SPECIAL_CHARS);
        $number = filter_var($number, FILTER_SANITIZE_NUMBER_INT);
        return $number;
    }

    public static function getHashPassword($password) {
        if (empty($password)) {
            throw new Exception("Senha é obrigatória.");
        }
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public static function comparePassword($password, $hash) {
        if (empty($password) || empty($hash)) {
            throw new Exception("A senha e o hash são parâmetros obrigatórios.");
        }
        return password_verify($password, $hash);
    }
}