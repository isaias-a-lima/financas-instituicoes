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
}