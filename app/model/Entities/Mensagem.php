<?php
namespace app\model\entities;

class Mensagem {
    public $to;
    public $subject;
    public $message;
    public $from;

    public function __construct($to, $subject, $message, $from) 
    {
        $this->to = $to;
        $this->subject = $subject;
        $this->message = $message;
        $this->from = $from;
    }
}