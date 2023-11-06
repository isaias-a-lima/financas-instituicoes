function openUserModal(idIntituicao) {
    resetModal();
    $("#idi").val(idIntituicao);
    $("#userModal").modal();
}

function convidar() {
    let email = $("#e-mail").val();
    let funcao = $("#funcao").val();
    let idInstituicao = $("#idi").val();

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
        $("#form-permitir-user").submit();
    }
}

function resetModal() {
    $("#e-mail").css("border-color", "");
    $("#e-mail").val("");
    $("#funcao").css("border-color", "");
    $("#funcao").val("");
    $("#idi").css("border-color", "");
    $("#idi").val("");
    $("#errorModel").text("");
    $("#errorModel").css("display", "none");
}