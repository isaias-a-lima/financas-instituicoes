<?php
namespace app\lib;
class Constantes{
    const DEFAULT_DIR = "./app";
    const DEFAULT_LIB_DIR = "./app/lib";
    const DEFAULT_CONTROLLER_DIR = "./app/controller";
    const DEFAULT_VIEW_DIR = "./app/view";
    const DEFAULT_MODEL_DIR = "./app/model";
    const DEFAULT_EXCEPTIONS_DIR = "./app/exceptions";
    const DEFAULT_MODULES_DIR = "./app/modules";

    // Mensagens
    const CAN_NOT_SAVE_MOVIMENTACOES = "Não foi possível salvar essa Movimentação. Verifique os fechamentos.";
    const CAN_NOT_UPDATE_MOVIMENTACOES = "Não foi possível alterar essa Movimentação. Verifique os fechamentos.";

    const HAS_NOT_MOVIMENTACOES = "Não existem movimentações para o mês selecionado.";
    const HAS_FECHAMENTOS = "Já existe fechamento registrado para o Mês selecionado.";
    const MONTH_ENDED = "O Mês selecionado deve estar encerrado.";

    const EMAIL_NOT_FOUND = "E-mail não encontrado.";

    const JUST_TITULAR_CAN_UPDATE = "Somente o titular da instituição pode fazer alterações";

    const SEMANA = [
        0 => "Domingo",
        1 => "Segunda-feira",
        2 => "Terça-feira",
        3 => "Quarta-feira",
        4 => "Quinta-feira",
        5 => "Sexta-feira",
        6 => "Sábado"
    ];

    const MES = [
        0 => "...Escolha um mês",
        1 => "Janeiro",
        2 => "Fevereiro",
        3 => "Março",
        4 => "Abril",
        5 => "Maio",
        6 => "Junho",
        7 => "Julho",
        8 => "Agosto",
        9 => "Setembro",
        10 => "Outubro",
        11 => "Novembro",
        12 => "Dezembro"
    ];

    //PROPERTIES    
    //const MAIL_FROM = self::getXML();

    public static function getMailFromByXML() {
        $xml = simplexml_load_file("../../lib/properties.xml");
        if ($xml) {
            return $xml->envioMail->from;
        } else {
            return "";
        }
    }

    const USER_FUNCTIONS = [
        "TITULAR"=>["cod"=>1, "funcao"=>"titular"],
        "TESOUREIRO"=>["cod"=>2, "funcao"=>"tesoureiro"],
        "FISCAL"=>["cod"=>3, "funcao"=>"fiscal"]
    ];
}