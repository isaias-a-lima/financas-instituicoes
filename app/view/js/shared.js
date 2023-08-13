$(document).ready(function () {
    $("#errorMsg").fadeOut(5000);

    getLocation();

});

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
    } else { 
        window.alert("Seu browser não suporta Geolocalização.");
    }
}

function showPosition(position) {
    let local = position.coords.latitude + "" + position.coords.longitude;
    $("#local").val(local);
}

function showError(error) {
    switch (error.code) {
        case error.PERMISSION_DENIED:
            window.alert("Usuário rejeitou a solicitação de Geolocalização.");
            break;
        case error.POSITION_UNAVAILABLE:
            window.alert("Localização indisponível.");
            break;
        case error.TIMEOUT:
            window.alert("A requisição expirou.");
            break;
        case error.UNKNOWN_ERROR:
            window.alert("Algum erro desconhecido aconteceu.");
            break;
    }
}