<?php
namespace app\controller;

use app\lib\SecurityUtil;
use app\model\dao\UsuarioDao;
use app\model\entities\Usuario;
use app\model\entities\Mensagem;
use Exception;

class UsuarioController {

    private UsuarioDao $usuarioDao;

    public function __construct() {
        $this->usuarioDao = new UsuarioDao();
    }

    /**
     * Retorna um objeto do tipo Usuario
     * @return Usuario|false
     */
    public function getUsuario(int $idUsuario) {
        $result = false;
        try {
            if (!isset($idUsuario)) {
                throw new Exception("Nenhum usuário selecionado.");
            }

            $result = $this->usuarioDao->getUsuarioById($idUsuario);

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return $result;
    }

    public function saveUsuario(Usuario $usuario) {
        
        try {
            if (!isset($usuario)) {
                throw new Exception("Usuário é obrigatório.");
            }

            $result = $this->usuarioDao->saveUsuario($usuario);

            if (isset($result) && $result !== false) {
                $codPage = RenderController::PAGES['LOGIN']['cod'];
                $link = "<a href='./?p=$codPage'>Clique aqui para entrar.</a>";
                $msg = "Usuário cadastrado com sucesso! $link";
                throw new Exception($msg);
            }

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function updateUsuario(Usuario $usuario) {
        $result = false;
        try {
            if(!isset($usuario)) {
                throw new Exception("Usuário é obrigatório.");
            }

            $result = $this->usuarioDao->updateUsuario($usuario);

            if(is_int($result) && $result > 0) {
                $codPage = RenderController::PAGES['HOME']['cod'];
                echo "<script>location.replace('./?p=$codPage');</script>";
            } else {
                throw new Exception("Nenhuma alteração registrada.");
            }

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return $result;
    }

    public function resetarSenhaEtapa1(string $email, string $local): Mensagem {
        $result = null;
        try {
            if (!isset($email) ) {
                throw new Exception("E-mail é obrigatório.");
            }

            $chave = rand(0, 1000);
            //$chave = SecurityUtil::getHashPassword(323);
            $chaveHash = SecurityUtil::getHashPassword($chave);

            $subject = "Tesouraria Prática - Resetar senha";

            $message = "
                <html>
                <head>
                <title>$subject</title>
                </head>
                <body>
                <h2>$subject</h2>
                <p>
                Você está recebendo esse e-mail por ter solicitado o resete de senha.<br>
                Caso não tenha solicitado, favor ignorar.<br>
                Clique no link abaixo para resetar a sua senha.<br>
                Você será redirecionado para a página de reset, e quando solicitado, deverá digitar a chave abaixo:<br>                
                <strong style='color: red; font-size:16pt;'>$chave</strong><br>              
                <a href='https://ikdesigns.com.br/tesouraria/?p=6&step=2'>Clique aqui para resetar sua senha.</a>                                
                </p>
                </body>
                </html>
            ";

            $usuario = $this->usuarioDao->getUsuarioByEmail($email);

            if (isset($usuario) && !empty($usuario->getEmail())) {

                $res = $this->usuarioDao->insertChaveResetSenha($usuario, $chaveHash, $local);
                
                if (is_numeric($res)) {
                    $mensagem = new Mensagem($usuario->getEmail(), $subject, $message, "suporte@ikdesigns.com.br");
                    $result = $mensagem;
                }
            } else {
                $txt = "E-mail " . $usuario->getEmail() . " não enviado. ";
                throw new Exception($txt);
            }

        } catch (Exception $e) {
            throw new Exception($e);
        }

        return $result;
    }

    public function resetarSenhaEtapa2(Usuario $usuario, string $chave) {
        $result = false;
        try {
            if(!isset($usuario) || !isset($chave)) {
                throw new Exception("Usuário e chave são obrigatórios.");
            }

            $usuario2 = $this->usuarioDao->getUsuarioByEmail($usuario->getEmail());

            if (!is_object($usuario2) || false == $usuario2) {              
                throw new Exception("Usuário não encontrado com essas informações. Favor tente novamente.");
            }

            $chaveAux = $this->usuarioDao->verifyChave($usuario2->getIdUsuario());

            if (!SecurityUtil::comparePassword($chave, $chaveAux)) {
                throw new Exception("Chave inválida. Por favor, faça o reset de senha novamente.");
            }
            
            if (null != $usuario->getSenha()) {
                $result = $this->usuarioDao->updateSenha($usuario2->getIdUsuario(), $usuario->getSenha());
                if (is_int($result) && $result > 0) {
                    $msg = "Senha alterada com sucesso.";                    
                    echo "<script>location.replace('./?p=0&msg=$msg');</script>";                    
                }
            }

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

}