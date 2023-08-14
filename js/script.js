function togglePasswordVisibility() {
    var passwordInput = document.getElementById("password");
    var toggleButton = document.getElementsByClassName("toggle-password")[0];
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        toggleButton.textContent = "ocultar";
    } else {
        passwordInput.type = "password";
        toggleButton.textContent = "mostrar";
    }
}

// Obtiene el valor del parámetro GET 'etiqueta_mostrada'
let parametroGet = new URLSearchParams(window.location.search);
let numero = parametroGet.get("resultado");
// Obtiene la etiqueta según el valor del parámetro GET
let etiquetaAMostrar = document.getElementById("alerta" + numero);



// Define una función para ocultar la etiqueta elegida
function ocultarEtiqueta() {
    etiquetaAMostrar.style.display = "none";
}
// Establece un temporizador para ocultar la etiqueta después de 5 segundos (5000 ms)
setTimeout(ocultarEtiqueta, 4000);