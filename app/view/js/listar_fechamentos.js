$(document).ready(function(){

    $("#btn-periodo").click(function(){
        const p = $("#p").val();
        const idi = $("#idi").val();
        const ano = $("#ano").val();
        let url = "./?p=" + p + "&idi=" + idi + "&ano=" + ano;
        document.location.href = url;
    });

    let anoBackup = $("#ano").val();

    $("#ano").blur(function(){
        const ano = $("#ano").val();        
        if(ano > 9999 || ano < 2023) {
            alert("O \"ano\" deve estar entre 2023 e 9999.");
            if (anoBackup !== undefined) {
                $("#ano").val(anoBackup);
            }
        }else{
            anoBackup = $("#ano").val();
        }
    });

});