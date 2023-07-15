<?php
namespace app\controller;

class RenderController {

    const PAGES = [
        "LOGIN"=>["cod"=>1, "page"=>"/login.php"],
        "HOME"=>["cod"=>2, "page"=>"/home.php"],
        "CADASTRO_USUARIO"=>["cod"=>3, "page"=>"/cadastro_usuario.php"],
        "CADASTRO_INSTITUICAO"=>["cod"=>4, "page"=>"/cadastro_instituicao.php"],
        "EDITAR_USUARIO"=>["cod"=>5, "page"=>"/editar_usuario.php"],
        "RESETAR_SENHA"=>["cod"=>6, "page"=>"/resetar_senha.php"],
        "EDITAR_INSTITUICAO"=>["cod"=>7, "page"=>"/editar_instituicao.php"],
        "CADASTRO_ENTRADA"=>["cod"=>8, "page"=>"/cadastro_entrada.php"],
        "LISTAR_ENTRADAS"=>["cod"=>9, "page"=>"/listar_entradas.php"],
        "LISTAR_INSTITUICOES"=>["cod"=>10, "page"=>"/listar_instituicoes.php"]
    ];

    private SessionController $sessao;

    public function __construct()
    {
        $this->sessao = SessionController::getInstance();
    }

    /**
     * Renderizar páginas. O parâmetro codPage está associado a const PAGES e define qual página deve ser renderizada.
     */
    public function rendering(int $codPage) {
        if ($this->sessao->hasSession($this->sessao::ID_USUARIO) || self::PAGES['CADASTRO_USUARIO']['cod'] == $codPage) {

            if ($codPage == 0) {
                $this->sessao->closeSession();
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
                $this->sessao->closeSession();
                return self::PAGES['RESETAR_SENHA']['page'];
            }
            return self::PAGES['LOGIN']['page'];
        }
    }
}