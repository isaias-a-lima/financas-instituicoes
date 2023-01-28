<?php
namespace app\exceptions;

use Exception;

class ExceptionUtil {

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

}