$(document).ready(function(){    
    
    $("#btn-gerar-pdf").click(function() {
        $("#form-pdf").submit();
    });

    $("#btn-enviar-mail").click(function() {
        $("#is-mail").val("1");
        
        const windowFeatures = "left=100, top=100, width=300, height=300";
        const janTarget = "jan1";
        const url = "";

        const janela = window.open(
            url,
            janTarget,
            windowFeatures
        );

        if (!janela) {
            alert("Habilite o javascript do seu navegador para o melhor funcionamento do sistema.");
        }

        $("#form-pdf").attr("target", janTarget);

        $("#form-pdf").submit();
    });
});