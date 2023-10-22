<?php

use app\lib\Constantes;
use Dompdf\Dompdf;

require_once "../../lib/dompdf/autoload.inc.php";
require_once "../../lib/constantes.php";

$html = $fileName = $mailTo = $replyTo = $mailSubject = $mailContent = $fileString = "";
$isEnvioPorEmail = false;

if ($_SERVER['REQUEST_METHOD']) {

    $mailFrom = "";

    try {
        $mailFrom = Constantes::getMailFromByXML();
    } catch (Exception $e) {
        echo $e->getMessage();
    }

    $html = isset($_POST['html-to-pdf']) ? $_POST['html-to-pdf'] : null;
    $fileName = isset($_POST['file-name']) ? $_POST['file-name'] : null;
    $isEnvioPorEmail = isset($_POST['is-mail']) ? $_POST['is-mail'] == "1" : $isEnvioPorEmail;
    $mailTo = isset($_POST['mail-to']) ? $_POST['mail-to'] : "";
    $replyTo = isset($_POST['reply-to']) ? $_POST['reply-to'] : "";
    $mailSubject = isset($_POST['mail-subject']) ? $_POST['mail-subject'] : "";
    $mailContent = isset($_POST['mail-content']) ? $_POST['mail-content'] : "";

    $dir = "../../lib/temp/" . $fileName;

    if (isset($html)) {
        $domPDF = new Dompdf();
        $domPDF->loadHtml($html,'UTF-8');

        $domPDF->setPaper('A4', 'portrait');

        $domPDF->render();

        if (isset($fileName)) {
            if ($isEnvioPorEmail) {
                $fileString = $domPDF->output();
                $pdf = fopen($dir, "w");
                fwrite($pdf, $fileString);
                fclose($pdf);
            } else {
                $domPDF->stream($fileName);
            }
        } else {
            $domPDF->stream();
        }
    } else {
        echo "<script>window.alert('Sem dados para gerar PDF.');</script>";
    }
} else {
    echo "ERRO: Tente novamente mais tarde, ou entre em contato e comunique o problema.";
    echo "suporte@ikdesigns.com.br";
}

?>

<form name="formjan1" method="post" action="../../lib/enviaMailComAnexo.php">
    <input type="hidden" name="to" value="<?=$mailTo?>">
    <input type="hidden" name="from" value="<?=$mailFrom?>">
    <input type="hidden" name="subject" value="<?=$mailSubject?>">
    <input type="hidden" name="message" value="<?=$mailContent?>">
    <input type="hidden" name="anexo" value="<?=$fileName?>">
</form>

<?php
if ($isEnvioPorEmail) {
    echo "<script>document.formjan1.submit();</script>";
}
?>