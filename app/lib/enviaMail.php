<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $to = $_POST['to'];
  $subject = $_POST['subject'];
  $message = $_POST['message'];
  $from = $_POST['from'];

  // To send HTML mail, the Content-type header must be set
  $headers[] = "MIME-Version: 1.0";
  $headers[] = "Content-type: text/html; charset=UTF-8";

  // Additional headers
  $headers[] = "From: Suporte <$from>";

  // Mail it
  mail($to, $subject, $message, implode("\r\n", $headers));
}

?>