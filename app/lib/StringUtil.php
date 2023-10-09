<?php
class StringUtil {
    
    public static function removeCaracteresEspeciais($str) {
        return preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim($str)));
    }
}
?>