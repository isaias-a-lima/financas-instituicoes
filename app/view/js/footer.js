$(document).ready(function() {
    let doc = $(document).height();
    let win = $(window).height();

    if (doc > win) {
        $("footer").css("bottom","none");
    } else {
        $("footer").css("bottom",0);
    }
});