<?php
class EmailUtil
{
    private string $to;
    private string $subject;
    private string $message;
    private string $header;

    public function __construct(string $to, string $subject, string $message)
    {
        $this->to = $to;
        $this->subject = $subject;
        $this->message = $message;
        $this->header = "MIME-Version: 1.0" . "\r\n";        
        $this->header .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $this->header .= 'From: <suporte@ikdesigns.com>' . "\r\n";        
    }

    public function sendMail() {
        return mail($this->to, $this->subject, $this->message, $this->header);
    }
}
