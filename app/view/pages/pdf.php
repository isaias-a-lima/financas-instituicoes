<?php

use Dompdf\Dompdf;

require_once "../../lib/dompdf/autoload.inc.php";

if ($_SERVER['REQUEST_METHOD']) {

    $html = isset($_POST['html-to-pdf']) ? $_POST['html-to-pdf'] : null;
    $fileName = isset($_POST['file-name']) ? $_POST['file-name'] : null;

    if (isset($html)) {
        $domPDF = new Dompdf();
        $domPDF->loadHtml($html,'UTF-8');

        $domPDF->setPaper('A4', 'portrait');

        $domPDF->render();

        if (isset($fileName)) {
            $domPDF->stream($fileName);    
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