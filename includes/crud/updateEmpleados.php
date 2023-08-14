<?php
session_start();
require '../config/conexion.php';
require '../templates/consultarEmp.php';
//variable para la conexion
$conexion = "";
//arreglo para guardar los errores
$listaErrores = [];

$idEmpleado = "";
$nombre = "";
$apellidoPat = "";
$apellidoMat = "";
$nacimiento = "";
$rfc = "";
$ingreso = "";
$genero = "";
$estatus = "";
$domicilio = "";
$telefono = "";
$fotografia = "";
$puesto = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conexion = conectar();
    //pasar los datos post a variables
    $idEmpleado = $_POST['idEmpleado'];
    $nombre = $_POST['nombre'];
    $apellidoPat = $_POST['apellidoPaterno'];
    $apellidoMat = $_POST['apellidoMaterno'];
    $nacimiento = date('Y-m-d', strtotime($_POST['fechaNacimiento']));
    $rfc = $_POST['rfc'];
    $ingreso = date('Y-m-d', strtotime($_POST['fechaIngreso']));
    $genero = $_POST['genero'];
    $estatus = $_POST['estatus'];
    $domicilio = $_POST['domicilio'];
    $telefono = $_POST['telefono'];
    $puesto = $_POST['puesto'];
    $resultado = fotografia($conexion, $idEmpleado);
    $fotografias = mysqli_fetch_assoc($resultado);
    $fotografia = $fotografias['fotografia'];

    //pasar los datos POST a una variable SESSION
    $_SESSION['idEmpleado'] = $_POST['idEmpleado'];
    $_SESSION['nombre'] = $_POST['nombre'];
    $_SESSION['apellidoPaterno'] = $_POST['apellidoPaterno'];
    $_SESSION['apellidoMaterno'] = $_POST['apellidoMaterno'];
    $_SESSION['fechaNacimiento'] = $_POST['fechaNacimiento'];
    $_SESSION['rfc'] = $_POST['rfc'];
    $_SESSION['fechaIngreso'] = $_POST['fechaIngreso'];
    $_SESSION['genero'] = $_POST['genero'];
    $_SESSION['estatus'] = $_POST['estatus'];
    $_SESSION['domicilio'] = $_POST['domicilio'];
    $_SESSION['telefono'] = $_POST['telefono'];
    $_SESSION['puesto'] = $_POST['puesto'];

    //asiganar la fotografia de files hacia una variable
    $newImagen = $_FILES['fotografia'];

    if (!$idEmpleado) {
        $listaErrores[] = 'Debes añadir un Id de Empleado';
    }
    if (!$nombre) {
        $listaErrores[] = 'Debes añadir un nombre';
    }
    if (!$apellidoPat) {
        $listaErrores[] = 'Debes añadir un Apellido';
    }
    if (!$nacimiento) {
        $listaErrores[] = 'Debes añadir la Fecha de Nacimiento';
    }
    if (!$rfc) {
        $listaErrores[] = 'Debes añadir el RFC';
    }
    if (!$ingreso) {
        $listaErrores[] = 'Debes añadir una Fecha de Ingreso';
    }
    if (!$genero) {
        $listaErrores[] = 'Debes seleccionar un genero';
    }
    if (!$estatus) {
        $listaErrores[] = 'Debes seleccionar un estatus';
    }
    if (!$domicilio) {
        $listaErrores[] = 'Debes añadir un domicilio';
    }
    if (!$telefono) {
        $listaErrores[] = 'Debes añadir un numero de telefono';
    }
    if (!$puesto) {
        $listaErrores[] = 'Debes seleccionar un puesto';
    }

    //validar por tamaño de imagen (5Mb máximo)
    $medida = 1000 * 5000;

    if ($newImagen['size'] > $medida) {
        $listaErrores[] = 'La imagen es muy grande';
    }

    //verificar que la lista de errores este vacia
    if (empty($listaErrores)) {
        $carpetaImagenes = '../../imagenes/';
        if (!is_dir($carpetaImagenes)) {
            mkdir($carpetaImagenes);
        }

        if($newImagen['name']){
            //verificar que la imagen previa exista
            if (file_exists($carpetaImagenes . $fotografia)){
                //Eliminar imagen previa
                unlink($carpetaImagenes . $fotografia);
            }
            $nombreImagen = md5(uniqid(rand(), true))  . ".jpg";
        } else {
            $nombreImagen = $fotografia;
        }

        //insersion a la base de datos
        $queryUpdate =  "UPDATE empleado SET nombre = '$nombre', apellidoPaterno ='$apellidoPat', apellidoMaterno = '$apellidoMat', fechaNacimiento = '$nacimiento', rfc = '$rfc', fechaIngreso ='$ingreso', genero ='$genero', estatus ='$estatus', domicilio ='$domicilio', telefono ='$telefono', fotografia ='$nombreImagen', puesto ='$puesto' WHERE idEmpleado = '$idEmpleado'";
        //ejecutamos la insersion
        try {
            if ($resultado = mysqli_query($conexion, $queryUpdate)) {
                //subimos la imagen al servidor, se mueve del espacio temporal a la carpeta destino
                move_uploaded_file($newImagen['tmp_name'], $carpetaImagenes . $nombreImagen);
                mysqli_close($conexion);
                header('Location: ../../index.php?resultado=2');
            } else {
                throw new Exception($conexion->error);
                mysqli_close($conexion);
            }
        } catch (Exception $e) {
            $listaErrores[] = 'Error al Insertar:' .  $e->getMessage();
            $_SESSION['errores'] = $listaErrores;
            header('Location: ../../actualizarEmp.php');
        }
    } else {
        $_SESSION['errores'] = $listaErrores;
        header('Location: ../../actualizarEmp.php');
    }
}
