<?php
namespace app\exceptions;

use app\controller\RenderController;
use Exception;

class ExceptionUtil {

    const RESETAR = RenderController::PAGES['RESETAR_SENHA']['cod'];

    const MESSAGES = [
        "1062"=>"Esse registro já existe no sistema.<br>Se estiver com problemas utilize a página de <a href='./?p=22'>contato</a> para falar conosco."
    ];

    public static function getError(Exception $e) {
        $file = $e->getFile();
        $line = $e->getLine();
        $code = $e->getCode();
        $message = substr($e->getMessage(), 0, strpos($e->getMessage(), "in"));
        return "Exception throw in $file on line $line: [Code $code] $message";
    }

    public static function getMessageError(Exception $e) {        
        return $e->getMessage();
    }

    public static function handleError(Exception $e) {
        if (strpos($e->getMessage(), "violation: 1062") !== false) {
            return self::MESSAGES["1062"];
        }
        return $e->getMessage();
    }

}