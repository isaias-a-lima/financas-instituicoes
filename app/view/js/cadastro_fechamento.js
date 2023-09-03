$(document).ready(function(){
    $("#mes").change(function(){
        let p = $("#p").val();
        let idi = $("#idInstituicao").val();
        let mes = $("#mes").val();
        let url = "./?p=" + p + "&idi=" + idi + "&mes=" + mes;

        window.location.href = url;
    });
});