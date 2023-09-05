<?php

use app\controller\RenderController;
use app\controller\SessionController;
use app\lib\SecurityUtil;

$sessao = SessionController::getInstance();
$usuario = isset($usuario) ? $usuario : $sessao->getSessionUser();
$msg = "";
$msgError = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {

        $codigos = ["EYO963", "WTI852", "QRU741"];

        $codimage = SecurityUtil::sanitizeString(isset($_POST['codimage']) ? $_POST['codimage'] : "");
        $codimage2 = SecurityUtil::sanitizeString(isset($_POST['codimage2']) ? $_POST['codimage2'] : "");

        if ($codimage != $codimage2) {
            throw new Exception("O código da imagem não corresponde.");
        }

        $to = "contato@ikdesigns.com.br";
        $nome = SecurityUtil::sanitizeString(isset($_POST['nome']) ? $_POST['nome'] : "");
        $subject = SecurityUtil::sanitizeString(isset($_POST['assunto']) ? $_POST['assunto'] : "");
        $message = SecurityUtil::sanitizeString(isset($_POST['mensagem']) ? $_POST['mensagem'] : "");
        $from = SecurityUtil::sanitizeString(isset($_POST['email']) ? $_POST['email'] : "");

        $msgMail = "
                <html>
                <head>
                <title>$subject</title>
                </head>
                <body>
                <h2>Contato da Tesouraria Prática</h2>
                <p>
                Nome: $nome<br>
                E-mail: $from<br>
                Assunto: $subject<br>                           
                </p>
                <p>
                $message
                </p>
                </body>
                </html>
            ";

        // To send HTML mail, the Content-type header must be set
        $headers[] = "MIME-Version: 1.0";
        $headers[] = "Content-type: text/html; charset=UTF-8";

        // Additional headers
        $headers[] = "From: Contato da Tesouraria <$to>";

        // Mail it
        $result = mail($to, $subject, $msgMail, implode("\r\n", $headers));
        if(is_bool($result) && $result) {
            $msg = "Mensagem enviada com sucesso. Aguarde nossa resposta. Obrigado!";
            $msgError = "<div class='alert alert-danger'>$msg</div>";
        } else {
            $msg = "Algo deu errado. Em alternativa, envie um e-mail para <strong>contato@ikdesigns.com.br</strong>";
            $msgError = "<div class='alert alert-danger'>$msg</div>";
        }
    } catch (Exception $e) {
        $msg = $e->getMessage();
        $msgError = "<div class='alert alert-danger'>$msg</div>";
    }
}

include "./app/view/sessionInfo.php";

?>

<section class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">
            <li>
                <a href="./?p=<?= RenderController::PAGES['HOME']['cod'] ?>">
                    <i class="glyphicon glyphicon-arrow-left"></i>
                    Home
                </a>
            </li>
            <li class="active">Contato</li>
        </ol>
    </div>
</section>

<section class="row">
    <div class="col-md-12">
        <?= $msgError ?>
    </div>

    <div class="col-md-12">
        <h3>Contato</h3>

        <p>
            Envie sua mensagem através do formulário abaixo.
        </p>
    </div>

    <div class="col-md-6">
        <form method="post" autocomplete="off" action="<?php $_SERVER['PHP_SELF'] ?>">
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="nome">Nome</label>
                    <input class="form-control" type="mail" name="nome" id="nome" value="<?=$usuario->getNome()?>" readonly required />
                </div>

                <div class="col-md-6">
                    <label for="email">E-mail</label>
                    <input class="form-control" type="mail" name="email" id="email" value="<?=$usuario->getEmail()?>" readonly required />
                </div>
            </div>

            <input type="hidden" name="codimage2" id="codimage2" />

            <div class="form-group">
                <label for="assunto">Assunto</label>
                <select class="form-control" name="assunto" id="assunto" required>
                    <option value="">...Selecione</option>
                    <option value="Suporte">Suporte</option>
                    <option value="Sugestão">Sugestão</option>
                    <option value="Reclamação">Reclamação</option>
                    <option value="Outro">Outro</option>
                </select>
            </div>

            <div class="form-group">
                <label for="mensagem">Mensagem</label>
                <textarea class="form-control" name="mensagem" id="mensagem"></textarea>
            </div>

            <img src="./app/view/images/01.jpg" id="imgcodigo" style="width: 90px;" />
            <div class="form-group row">
                <div class="col-md-4">
                    <label for="codimage">Digite o codigo</label>
                    <input class="form-control" type="text" name="codimage" id="codimage" required />
                </div>
            </div>

            <button class="btn btn-primary" id="enviar">Enviar</button>
        </form>
    </div>
</section>
<script src="./app/view/js/contato.js"></script>