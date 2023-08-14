<?php

//creamos una funcion para consultar los puestos
function empleado($conexion, $id){
    $conexion = $conexion;
    $id = $id;
        $consultaEmp = "SELECT * FROM empleado WHERE idEmpleado = $id";
    $resultado = mysqli_query($conexion, $consultaEmp);
    return $resultado;
}

function fotografia($conexion, $id){
    $conexion = $conexion;
    $id = $id;
        $consultaFoto = "SELECT fotografia FROM empleado WHERE idEmpleado = $id";
    $resultado = mysqli_query($conexion, $consultaFoto);
    return $resultado;
}
?>