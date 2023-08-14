<?php
//llamamos el archivo de conexion
include('../config/conexion.php');
unset($_SESSION);
$errores = [];
$auth = false;

//autenticación del usuario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //iniciamos una variable que llame la conexion
    $conexion = conectar();
    if ($conexion) {
        session_start();
        //recibimos un usuario que viene desde el metodo post
        $password = mysqli_real_escape_string($conexion, $_POST['password']);
        $user = mysqli_real_escape_string($conexion, $_POST['usuario']);
        echo $password;
        //notificacion de datos vacios
        if (!$password) {
            mysqli_close($conexion);
            echo '<script>window.location.href = "../../login.php?error=true";</script>';
        }
        if (!$user) {
            mysqli_close($conexion);
            echo '<script>window.location.href = "../../login.php?error=true";</script>';
        }
        //generamos el query para consultar dentro de la tabla usuarios
        $queryUser = "SELECT * FROM usuarios WHERE nombre = '$user';";
        //hacemos la consulta a la base de datos
        $consultaUser = mysqli_query($conexion, $queryUser);
        //comprabacion del usuario
        if ($consultaUser->num_rows) {
            $usuario = mysqli_fetch_assoc($consultaUser);
            if ($usuario['password'] == $password) {
                $auth = true;
                if ($auth) {
                    //header('Location: login.php');
                    $_SESSION['login'] = true;
                    mysqli_close($conexion);
                    echo "<script>location.href='../../index.php';</script>";
                } else {
                    mysqli_close($conexion);
                    echo '<script>window.location.href = "../../login.php?error=true";</script>';
                }
            } else {
                mysqli_close($conexion);
                echo '<script>window.location.href = "../../login.php?error=true";</script>';
            }
        }else {
            mysqli_close($conexion);
            echo '<script>window.location.href = "../../login.php?error=true";</script>';
        }
    }
}
