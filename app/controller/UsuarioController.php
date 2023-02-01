<?php
namespace app\controller;

use app\model\dao\UsuarioDao;
use app\model\entities\Usuario;
use EmailUtil;
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

    public function resetarSenhaEtapa1(string $email) {
        $result = false;
        try {
            if (!isset($email)) {
                throw new Exception("E-mail é obrigatório.");
            }

            $usuario = $this->usuarioDao->getUsuarioByEmail($email);

            if (is_object($usuario) && null != $usuario->getEmail()) {
                $subject = "Tesouraria Virtual - Resetar senha";
                $message = "
                    <html>
                    <head>
                    <title>$subject</title>
                    </head>
                    <body>
                        <h2>$subject</h2>
                        <p>
                            Clique no link abaixo para resetar a sua senha.<br>
                            Você será redirecionado para a página de reset.
                        </p>
                        <a href='https://ikdesigns.com.br/tesouraria/?p=6&step=2'>Clique aqui para resetar sua senha.</a>
                        <p>
                            Se você não solicitou isso favor ignorar.
                        </p>
                    </body>
                    </html>
                ";
                $emailUtil = new EmailUtil($usuario->getEmail(), $subject, $message);                
                if ($emailUtil->sendMail()) {
                    $msg = "E-mail enviado com sucesso.";
                    $link = "./?p=1&msg=$msg";
                    echo "<script>location.replace('$link');</script>";
                } else {
                    throw new Exception("E-mail não enviado.");
                }
            }

        } catch (Exception $e) {
            throw new Exception($e);
        }

        return $result;
    }

    public function resetarSenhaEtapa2(Usuario $usuario) {
        $result = false;
        try {
            if(!isset($usuario)) {
                throw new Exception("Usuário é obrigatório.");
            }

            $usuario2 = $this->usuarioDao->getUsuarioByRgAndEmail($usuario->getRg(), $usuario->getEmail());

            if (false == $usuario2) {              
                throw new Exception("Usuário não encontrado com essas informações. Favor tente novamente.");
            }
            
            if (is_object($usuario2) && null != $usuario2->getIdUsuario() && null != $usuario->getSenha()) {
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