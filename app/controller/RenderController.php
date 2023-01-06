<?php
namespace app\controller;

class RenderController {

    const PAGES = [
        "LOGIN"=>["cod"=>1, "page"=>"/login.php"],
        "HOME"=>["cod"=>2, "page"=>"/home.php"],
        "USUARIO"=>["cod"=>3, "page"=>"/usuario.php"]
    ];

    public static function rendering(int $codPage) {
        if (SessionController::hasSession()) {

            if ($codPage == 0) {
                SessionController::closeSession();
                return self::PAGES['LOGIN']['page'];
            }

            foreach(self::PAGES as $key => $value) {
                if ($value['cod'] == $codPage) {
                    return self::PAGES[$key]['page'];
                }
            }

            return self::PAGES['HOME']['page'];
        } else {
            
            return self::PAGES['LOGIN']['page'];
        }
    }
}