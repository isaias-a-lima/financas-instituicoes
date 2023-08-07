

function resetarSenhaEtapa1(mensagem) {
    document.enviarform.to.value = mensagem.to;
    document.enviarform.subject.value = mensagem.subject;
    document.enviarform.message.value = mensagem.message;
    document.enviarform.from.value = mensagem.from;
    document.enviarform.submit();
}