$(document).ready(function(){
    $("#mes").change(function(){
        let p = $("#p").val();
        let idi = $("#idInstituicao").val();
        let mes = $("#mes").val();
        let url = "./?p=" + p + "&idi=" + idi + "&mes=" + mes;

        window.location.href = url;
    });

    $("#saldoInicial").change(function(){
        atualizaFechamento();
    });

    $("#btnSalvar").click(function(){
        if ($("#isFirstClosing").val() == 1) {
            if ($("#saldoInicial").val() == "") {
                $("#errorAlert").text("Campo obrigatório.");
            } else {
                if (confirm("Deseja salvar este fechamento?")) {
                    $("#formfechamento").submit();
                }
            }
        } else {
            $("#formfechamento").submit();
        }
    });
});

function atualizaFechamento() {
    let saldoInicial = $("#saldoInicial").val() != "" ? parseFloat($("#saldoInicial").val()) : 0;
    let entradas = parseFloat($("#entradas").val());
    let saidas = parseFloat($("#saidas").val());
    let fluxoCaixa = entradas - saidas;
    let saldoFinal = saldoInicial + entradas - saidas;
    $("#saldoFinal").val(saldoFinal);

    let maiorValor = 0;
    maiorValor = saldoInicial > entradas ? saldoInicial : entradas;
    maiorValor = maiorValor > saidas ? maiorValor : saidas;
    maiorValor = maiorValor > fluxoCaixa ? maiorValor : fluxoCaixa;
    maiorValor = maiorValor > saldoFinal ? maiorValor : saldoFinal;

    let saldoInicialGrafico = saldoInicial > 0 ? saldoInicial / maiorValor * 100 : 0;
    let entradasGrafico = entradas > 0 ? entradas / maiorValor * 100 : 0;
    let saidasGrafico = saidas > 0 ? saidas / maiorValor * 100 : 0;
    let fluxoCaixaGrafico = fluxoCaixa > 0 ? fluxoCaixa / maiorValor * 100 : 0;
    let saldoFinalGrafico = saldoFinal > 0 ? saldoFinal / maiorValor * 100 : 0;

    $("#saldoInicialBarra").text(formatarMoeda(saldoInicial));
    $("#saldoInicialBarra2").attr("aria-valuenow",saldoInicialGrafico);
    $("#saldoInicialBarra2").css("width",(saldoInicialGrafico + "%"));

    $("#entradasBarra").text(formatarMoeda(entradas));
    $("#entradasBarra2").attr("aria-valuenow",entradasGrafico);
    $("#entradasBarra2").css("width",(entradasGrafico + "%"));

    $("#saidasBarra").text(formatarMoeda(saidas));
    $("#saidasBarra2").attr("aria-valuenow",saidasGrafico);
    $("#saidasBarra2").css("width",(saidasGrafico + "%"));

    $("#fluxoCaixaBarra").text(formatarMoeda(fluxoCaixa));
    $("#fluxoCaixaBarra2").attr("aria-valuenow",fluxoCaixaGrafico);
    $("#fluxoCaixaBarra2").css("width",(fluxoCaixaGrafico + "%"));

    $("#saldoFinalBarra").text(formatarMoeda(saldoFinal));
    $("#saldoFinalBarra2").attr("aria-valuenow",saldoFinalGrafico);
    $("#saldoFinalBarra2").css("width",(saldoFinalGrafico + "%"));
}

function formatarMoeda(valor) {
    var valor = valor;
    valor = new Intl.NumberFormat("pt-BR").format(valor);
    return "R$ " + valor;
}