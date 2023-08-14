<?php
require '../config/conexion.php';
require '../templates/consultarEmp.php';

$conexion = "";
$id = "";
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])){
    $conexion = conectar();
    //evaluamos que no se un query inyection
    $id = mysqli_real_escape_string($conexion, $_GET['id']);
    $resultado = empleado($conexion, $id);
    if(isset($resultado)){
        //eliminar empleado
        $queryDelete = "UPDATE empleado SET estatus = 2 WHERE idEmpleado = $id";
        $resultado = mysqli_query($conexion, $queryDelete);

        if ($resultado) {
            header('Location: ../../index.php?resultado=3');
        }
    }
}
?>