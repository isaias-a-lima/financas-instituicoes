$(document).ready(function(){

    $("#btn-periodo").click(function(){
        const p = $("#p").val();
        const id = $("#id").val();
        const dataInicio = $("#dataInicio").val();
        const dataFim = $("#dataFim").val();
        let url = "./?p=" + p + "&id=" + id + "&dataInicio=" + dataInicio + "&dataFim=" + dataFim;
        document.location.href = url;
    });

});