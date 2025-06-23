import "./bootstrap";

if ("serviceWorker" in navigator) {
    window.addEventListener("load", function () {
        navigator.serviceWorker
            .register("/serviceworker.js")
            .then(function (registration) {
                console.log("SW registered: ", registration);
            })
            .catch(function (registrationError) {
                console.log("SW registration failed: ", registrationError);
            });
    });
}
