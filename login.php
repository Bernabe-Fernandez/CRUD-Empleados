<?php
    session_start();
    unset($_SESSION);
    $error = "";
    if ($_GET) {
        $respuesta = $_GET['error'];
        if ($respuesta) {
            $error = "!Inicio de Session Fallida¡ Usuario y/o Contraseña Incorrecta";
        }
    }
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- mandamos a llamar un API de google fonts para las tipografia-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Krub:wght@400;700&display=swap" rel="stylesheet">
    <!-- mandamos a llamar la hoja de estilos y la hoja de normalize -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/normalize.css">
    <title>Naercris</title>
</head>


<body>
    <?php if($error != "") : ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>
    <div class="contenedor-formulario contenedor">
        <div class="">
            <img src="img/logo.png" alt="logo" class="imagenLogin">
        </div>
        <form class="formulario" action="includes/templates/loguear.php" method="POST">
            <h1>Bienvenidos</h1>
            <fieldset>
                <legend>Inicia Sesion</legend>
                <div class="input">
                    <label for="usuario">Usuario</label>
                    <input type="text" name="usuario" id="usuario"  placeholder="Ingresa tu usuario">
                </div>
                <label for="password">Password:</label>
                <div class="password-wrapper">
                    <input type="password" name="password" id="password"  placeholder="Ingresa tu contraseña">
                    <button type="button" class="toggle-password" onclick="togglePasswordVisibility()">mostrar</button>
                </div>
            </fieldset>

            <!-- boton para iniciar sesion -->
            <div class="input-login">
                <br>
                <input type="submit" class="boton-login" value="Ingresar">
            </div>
        </form>
    </div>
    <script src="js/script.js"></script>
</body>

</html>