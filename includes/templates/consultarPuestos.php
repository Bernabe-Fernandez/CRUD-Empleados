<?php

//creamos una funcion para consultar los puestos
function puestos($conexion){
    $conexion = $conexion;
        $consultaPuestos = "SELECT * FROM puestos"; 
    $resultado = mysqli_query($conexion, $consultaPuestos);
    
    return $resultado;
}
?>