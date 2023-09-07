$(document).ready(function() {
    let doc = $(document).height();
    let win = $(window).height();

    if (doc > win) {
        showBtnGotoTop();
    } else {
        hideBtnGotoTop();
    }

    $("#btnGotoTop").click(function(){
        window.location.href = "#topo";
    });
});

function showBtnGotoTop() {
    $("#btnGotoTop").css("display","block");
}

function hideBtnGotoTop() {
    $("#btnGotoTop").css("display","none");
}