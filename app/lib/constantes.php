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
    const CAN_NOT_RECORD_ENTRADA = "Não será possível Registrar um nova Entrada visto que já foi realizado o fechamento do mês.";
    const CAN_NOT_SAVE_ENTRADA = "Não será possível Salvar essa Entrada visto que já foi realizado o fechamento do mês.";
    const CAN_NOT_UPDATE_ENTRADA = "Não será possível Editar essa Entrada visto que já foi realizado o fechamento do mês.";

    const CAN_NOT_RECORD_SAIDA = "Não será possível Registrar um nova Saída visto que já foi realizado o fechamento do mês.";
    const CAN_NOT_SAVE_SAIDA = "Não será possível Salvar essa Saída visto que já foi realizado o fechamento do mês.";
    const CAN_NOT_UPDATE_SAIDA = "Não será possível Editar essa Saída visto que já foi realizado o fechamento do mês.";

    const HAS_NOT_MOVIMENTACOES = "Não existem movimentações para o mês selecionado.";
    const HAS_FECHAMENTOS = "Já existe fechamento registrado para o Mês selecionado.";
    const MONTH_ENDED = "O Mês selecionado deve estar encerrado.";

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
}