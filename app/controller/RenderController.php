<?php
namespace app\controller;

class RenderController {

    const PAGES = [
        "LOGIN"=>["cod"=>1, "page"=>"/login.php"],
        "HOME"=>["cod"=>2, "page"=>"/home.php"],
        "CADASTRO_USUARIO"=>["cod"=>3, "page"=>"/cadastro_usuario.php"],
        "CADASTRO_INSTITUICAO"=>["cod"=>4, "page"=>"/cadastro_instituicao.php"],
        "EDITAR_USUARIO"=>["cod"=>5, "page"=>"/editar_usuario.php"],
        "RESETAR_SENHA"=>["cod"=>6, "page"=>"/resetar_senha.php"]
    ];

    public static function rendering(int $codPage) {
        if (SessionController::hasSession() || self::PAGES['CADASTRO_USUARIO']['cod'] == $codPage) {

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
            if ($codPage == self::PAGES['RESETAR_SENHA']['cod']) {
                SessionController::closeSession();
                return self::PAGES['RESETAR_SENHA']['page'];
            }
            return self::PAGES['LOGIN']['page'];
        }
    }
}