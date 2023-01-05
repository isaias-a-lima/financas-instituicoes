<?php
namespace app\controller;

class RenderController {

    const PAGES = [
        [1, "LOGIN", "/login.php"],
        [2, "HOME", "/home.php"],
        [3, "USUARIO", "/usuario.php"]
    ];

    public static function rendering(int $page) {
        if (SessionController::hasSession()) {

            if ($page == 0) {
                SessionController::closeSession();
                return self::PAGES[0][2];
            }

            for($iVertical = 0; $iVertical < count(self::PAGES); $iVertical++) {                
                if(self::PAGES[$iVertical][0] == $page) {
                    return self::PAGES[$iVertical][2];
                }
            }
            return self::PAGES[1][2];
        } else {
            return self::PAGES[0][2];
        }
    }
}