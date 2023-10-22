<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $to = $_POST['to'];
    $assunto = $_POST['subject'];
    $message = $_POST['message'];
    $remetente = $_POST['from'];
    $fileForm = $_POST['anexo'];
    $dir = "./temp/" . $fileForm;

    /* Cabeçalho da mensagem  */
    $boundary = "XYZ-" . date("dmYis") . "-ZYX";
    $headers = "MIME-Version: 1.0\n";
    $headers .= "From: $remetente\n";
    //$headers .= "Reply-To: $replyto\n";
    $headers .= "Content-type: multipart/mixed; boundary=\"$boundary\"\r\n";
    $headers .= "$boundary\n";

    
    if (file_exists($dir) and !empty($dir)) {

        $fp = fopen($dir, "rb"); 
        $anexo = fread($fp, filesize($dir)); 
        $anexo = base64_encode($anexo); 
        fclose($fp); 
        $anexo = chunk_split($anexo); 
        $mensagem = "--$boundary\n"; 
        $mensagem .= "Content-Transfer-Encoding: 8bits\n";
        $mensagem .= "Content-Type: text/html; charset=\"utf-8\"\n\n";
        $mensagem .= "$message\n";
        $mensagem .= "--$boundary\n";
        $mensagem .= "Content-Type: " . filetype($dir) . "\n";
        $mensagem .= "Content-Disposition: attachment; filename=\"" . basename($dir) . "\"\n";
        $mensagem .= "Content-Transfer-Encoding: base64\n\n";
        $mensagem .= "$anexo\n";
        $mensagem .= "--$boundary--\r\n";

        unlink($dir);
        
        if (mail($to, $assunto, $mensagem, $headers)) {
            echo "
            <br><br>
            <div style='font-family: Arial, Helvetica, sans-serif; text-align: center; color: MediumSeaGreen;'>
                Mensagem enviada com sucesso!<br>De $remetente para $to.
                <br>Já pode fechar esta janela.
            </div>
            ";
        } else {
            echo "
            <br><br>
            <div style='font-family: Arial, Helvetica, sans-serif; text-align: center; color: red;'>
                Ocorreu um erro ao enviar a mensagem!
            </div>
            ";
        }
    } else {
        echo "
        <br><br>
        <div style='font-family: Arial, Helvetica, sans-serif; text-align: center; color: red;'>
            Arquivo $fileForm não encontrado.
        </div>
        ";
    }

    echo "<script>function closeJanela() { window.close(); }</script>";
    echo "<script>setTimeout('closeJanela()', '2000');</script>";
}
