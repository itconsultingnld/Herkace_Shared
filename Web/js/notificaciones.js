/*var config = {


    apiKey: "KEY",
    authDomain: "appname-8e897.firebaseapp.com",
    databaseURL: "https://appname-8e897.firebaseio.com",
    projectId: "appname-8e897",
    storageBucket: "appname-8e897.appspot.com",
    messagingSenderId: "426308761658",
    appId: "1:426308761658:web:ecf9aa89e703fb72eedd03",
    measurementId: "G-4EQDEYD43J"

};
firebase.initializeApp(config);
firebase.analytics();
const messaging = firebase.messaging();
messaging
    .requestPermission()
    .then(function () {
        // MsgElem.innerHTML = "Notification permission granted."
        console.log("Notification permission granted.");
        // get the token in the form of promise
        return messaging.getToken()
    })
    .then(function (token) {
        document.cookie = "tokenM=" + token + "; path=/; max-age=3600";
    })
    .catch(function (err) {
        console.log("Unable to get permission to notify.", err);
    });
messaging.onMessage(function (payload) {
    console.log("Message received. ", payload);
    const { title, ...options } = payload.data;
    navigator.serviceWorker.ready.then(registration => {
        registration.showNotification(title, options);
    });
});

function subscripcion(token) {
    $.ajax({
        type: "POST",
        contentType: "application/json",
        headers: { "Authorization": "key=KEY" },
        url: "https://iid.googleapis.com/iid/v1/" + token + "/rel/topics/publicaciones",
        success: function (response) {
            console.log("Subscripción de Token" + response);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log("No se Registro el Token");
        }
    });
};*/

function addZero(i) {
    if (i < 10) {
        i = '0' + i;
    }
    return i;
};

function hoyFecha() {
    var hoy = new Date();
    var dd = hoy.getDate();
    var mm = hoy.getMonth() + 1;
    var yyyy = hoy.getFullYear();

    dd = addZero(dd);
    mm = addZero(mm);

    return yyyy + '-' + mm + '-' + dd;
};
function hoyHora() {
    var hoy = new Date();
    var hh = hoy.getHours();
    var mm = hoy.getMinutes();
    var ss = hoy.getSeconds();

    hh = addZero(hh);
    mm = addZero(mm);
    ss = addZero(ss);

    return hh + ':' + mm + ':' + ss;
}