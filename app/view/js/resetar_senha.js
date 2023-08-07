const home = "1";

$(document).ready(function() {
    $("#resetMsg").val("Processando o reset de senha.");
});

function resetarSenhaEtapa1(mensagem) {
    document.enviarform.to.value = mensagem.to;
    document.enviarform.subject.value = mensagem.subject;
    document.enviarform.message.value = mensagem.message;
    document.enviarform.from.value = mensagem.from;    
    document.enviarform.submit();
    setInterval("linkToHome()", 2000);    
}

function linkToHome() {
    let msg = "Resete de senha enviado para o seu e-mail.";
    let url = "./?p=" + home + "&msg=" + msg;
    location.href = url;    
}