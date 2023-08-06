$(document).ready(function(){

    $("#btn-periodo").click(function(){
        const p = $("#p").val();
        const idi = $("#idi").val();
        const dataInicio = $("#dataInicio").val();
        const dataFim = $("#dataFim").val();
        let url = "./?p=" + p + "&idi=" + idi + "&dataInicio=" + dataInicio + "&dataFim=" + dataFim;
        document.location.href = url;
    });

});