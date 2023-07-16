function openAvisoModal() {
    
    $("#avisoModal").css("top", "0");
    $("#avisoModal").css("left", "0");
    $("#avisoModal").css("width", "100%");
    $("#avisoModal").css("height", "100%");
    $("#avisoModal").show();
    setTimeout("closeAvisoModal()", 3000);
}

function closeAvisoModal() {
    $("#avisoModal").css("display", "none");
}


function openUserModal(idIntituicao) {
    resetModal();
    $("#idInstituicao").val(idIntituicao);
    $("#userModal").modal();
}

function convidar() {
    let email = $("#e-mail").val();
    let funcao = $("#funcao").val();
    let idInstituicao = $("#idInstituicao").val();

    if (email.length == 0) {
        $("#e-mail").css("border-color", "red");
        $("#e-mail").focus();
    } else if (funcao.length == 0) {
        $("#e-mail").css("border-color", "");
        $("#funcao").css("border-color", "red");
        $("#funcao").focus();
    } else if (idInstituicao.length == 0) {
        $("#errorModel").text("ID da instituição é obrigatório.");
        $("#errorModel").css("display", "block");
    } else {
        const msg = email + " | " + funcao + " | " + idInstituicao;
        $("#userModal").modal("hide");
        openAvisoModal()
    }
}

function resetModal() {
    $("#e-mail").css("border-color", "");
    $("#e-mail").val("");
    $("#funcao").css("border-color", "");
    $("#funcao").val("");
    $("#idInstituicao").css("border-color", "");
    $("#idInstituicao").val("");
    $("#errorModel").text("");
    $("#errorModel").css("display", "none");
}