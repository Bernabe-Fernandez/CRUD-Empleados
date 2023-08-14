<?php
session_start();
$logueo = "";
if (isset($_SESSION['login'])) {
    $logueo = $_SESSION['login'];
}

if($logueo != 1){
    header('Location: login.php');
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

<body onload="getData(paginaActual);">
    <!-- header -->
    <header>
        <div class="head">
            <div class="head-title">
                <h1>Corporativo Naercris S.A. de C.V.</h1>
            </div>
        </div>
    </header>
    <!-- barra menu -->
    <section class="container container-menu menu">
        <!-- menu de contenido -->
        <nav class="bar-nav">
            <ul class="bar-menu" id="bar-menu">
                <li class="menu--item">
                    <a class="menu--link" href="index.php">Lista Empleados</a>
                </li>
                <li class="menu--item">
                    <a class="menu--link" href="agregarEmp.php">Agregar Empleados</a>
                </li>
                <?php if ($logueo) : ?>
                    <li class="menu--item">
                        <a class="menu--link" href="includes/templates/cerrarSesion.php">Cerrar Sesion</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </section>