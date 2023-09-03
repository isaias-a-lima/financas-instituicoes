<?php
namespace app\controller;

use Exception;

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
        "LISTAR_INSTITUICOES"=>["cod"=>10, "page"=>"/listar_instituicoes.php"],
        "DASHBOARD_INSTITUICAO"=>["cod"=>11, "page"=>"/dashboard_instituicao.php"],
        "LISTAR_SAIDAS"=>["cod"=>12, "page"=>"/listar_saidas.php"],
        "LISTAR_FECHAMENTOS"=>["cod"=>13, "page"=>"/listar_fechamentos.php"],
        "LISTAR_CONTAS"=>["cod"=>14, "page"=>"/listar_contas.php"],
        "LISTAR_FATURAS"=>["cod"=>15, "page"=>"/listar_faturas.php"],
        "ERRO_404"=>["cod"=>16, "page"=>"/erro404.php"],
        "EDITAR_ENTRADA"=>["cod"=>17, "page"=>"/editar_entrada.php"],
        "CADASTRO_SAIDA"=>["cod"=>18, "page"=>"/cadastro_saida.php"],
        "EDITAR_SAIDA"=>["cod"=>19, "page"=>"/editar_saida.php"],
        "EDITAR_FECHAMENTO"=>["cod"=>20, "page"=>"/editar_fechamento.php"],
        "CADASTRO_FECHAMENTO"=>["cod"=>21, "page"=>"/cadastro_fechamento.php"]
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

        try {
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
        } catch (Exception $e) {
            return self::PAGES['ERRO_404']['page'];
        }

    }
}