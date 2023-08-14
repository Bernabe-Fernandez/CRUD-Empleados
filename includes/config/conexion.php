<?php
//funcion de conexion
function conectar(){
    $user = "root";
    $pass = "";
    $server = "localhost";
    $bd = "crud_empleados";

    //se hace la conexion a la base de datos
    $cone = mysqli_connect($server, $user, $pass, $bd);

    //validamos si la conexion es exitosa
    if(!$cone){
        die("Error al conectarse");
    }
    return $cone;
}
