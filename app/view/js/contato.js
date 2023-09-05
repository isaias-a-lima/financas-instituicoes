$(document).ready(function () {
    $("#enviar").attr("disabled", "true");

    const imgs = ["EYO963", "WTI852", "QRU741"];

    let rnd = getRandomIntInclusive(1, 3);
    let img = "./app/view/images/0" + rnd + ".jpg";
    $("#imgcodigo").attr("src", img);

    $("#codimage").change(function () {
        let codigo = $("#codimage").val();
        if (codigo == imgs[rnd - 1]) {
            $("#codimage2").val(codigo);
            $("#enviar").removeAttr("disabled");
        } else {
            $("#codimage2").val("");
            $("#enviar").attr("disabled", "true");
        }
    });
});

function getRandomIntInclusive(min, max) {
    min = Math.ceil(min);
    max = Math.floor(max);
    return Math.floor(Math.random() * (max - min + 1) + min); // The maximum is inclusive and the minimum is inclusive
}
