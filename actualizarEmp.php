<?php
//mandamos a llamar el header en nuestro index
require 'includes/app.php';
incluirTemplate('header');
incluirTemplate('consultarPuestos');
incluirTemplate('consultarEmp');
//generamos la conexion a la base de datos y solicitamos los puestos
require 'includes/config/conexion.php';
$conexion = conectar();
$puestos = puestos($conexion);

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

//verificar que ya se haya envio el formulario una vez al post
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    //llamar la funcion para consultar los datos
    $empleados = empleado($conexion, $id);
    foreach ($empleados as $empleado) {
        $idEmpleado = $empleado['idEmpleado'];
        $nombre = $empleado['nombre'];
        $apellidoPat = $empleado['apellidoPaterno'];
        $apellidoMat = $empleado['apellidoMaterno'];
        $nacimiento = date('d-m-Y', strtotime($empleado['fechaNacimiento']));
        $rfc = $empleado['rfc'];
        $ingreso = date('d-m-Y', strtotime($empleado['fechaIngreso']));
        $genero = $empleado['genero'];
        $estatus = $empleado['estatus'];
        $domicilio = $empleado['domicilio'];
        $telefono = $empleado['telefono'];
        $fotografia = $empleado['fotografia'];
    }
}
?>

<main class="contenedor registro">
    <h3>Actualizar Empleado</h3>
    <div class="boton-azul-rigth">
        <a href="index.php" class="boton-azul">Regresar</a>
    </div>
    <?php
    if (isset($_SESSION['errores'])) :
        $errores = $_SESSION['errores'];
        foreach ($errores as $error) : ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
    <?php
        endforeach;
        //limpiar el arreglo de errores
        unset($_SESSION['errores']);
    endif;
    ?>
    <!-- formulario de registro -->
    <!-- enctype nos ayuda a poder leer archivos que se envien en el formulario -->
    <div class="contenedor-formulario">
        <form method="POST" class="formulario" action="includes/crud/updateEmpleados.php" enctype="multipart/form-data">
            <!-- informacion propiedad -->
            <fieldset>
                <legend>Información Personal</legend>

                <label for="idEmpleado">Id Empleado:</label>
                <input type="text" id="idEmpleado" name="idEmpleado" placeholder="Id Empleado" value="<?php echo $idEmpleado; ?>">

                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" placeholder="Nombre" value="<?php echo $nombre; ?>">

                <label for="apellidoPaterno">Apellido Paterno</label>
                <input type="text" id="apellidoPaterno" name="apellidoPaterno" placeholder="Apellido Paterno" value="<?php echo $apellidoPat; ?>">

                <label for="apellidoMaterno">Apellido Materno</label>
                <input type="text" id="apellidoMaterno" name="apellidoMaterno" placeholder="Apellido Materno" value="<?php echo $apellidoMat; ?>">

                <label for="fechaNacimiento">Fecha de Nacimiento</label>
                <input type="date" id="fechaNacimiento" name="fechaNacimiento" max="2004-01-01" value="<?php echo $nacimiento; ?>">

                <label for="rfc">RFC</label>
                <input type="text" id="rfc" name="rfc" placeholder="RFC" value="<?php echo $rfc; ?>">

                <label for="fechaIngreso">Fecha de Ingreso</label>
                <input type="date" id="fechaIngreso" name="fechaIngreso" value="<?php echo $ingreso; ?>">

                <label for="genero">Genero:</label>
                <select id="genero" name="genero">
                    <option value="">--- Seleccione ---</option>
                    <option value="1">Masculino</option>
                    <option value="2">Femenino</option>
                    <option value="3">Sin Especificar</option>
                </select>

                <label for="estatus">Estatus:</label>
                <select id="estatus" name="estatus">
                    <option value="">--- Seleccione ---</option>
                    <option value="1">Activo</option>
                    <option value="2">Baja</option>
                </select>

                <label for="domicilio">Domicilio</label>
                <input type="text" id="domicilio" name="domicilio" placeholder="Domicilio" value="<?php echo $domicilio; ?>">

                <label for="telefono">Telefono:</label>
                <input type="number" id="telefono" name="telefono" placeholder="Telefono" value="<?php echo $telefono; ?>">

                <!-- parte del formulario para subir la imagen -->
                <label for="fotografia">Fotografia:</label>
                <!-- accept, condiciona que solo se suban imagenes -->
                <input type="file" id="fotografia" accept="image/jpeg, image/png" name="fotografia">
                <img src="imagenes/<?php echo $fotografia; ?>" alt="fotografia" class="imagen">

                <label for="puesto">Puesto</label>
                <select name="puesto" id="puesto">
                    <option value="">--Seleccione un Puesto--</option>
                    <?php foreach ($puestos as $puesto) : ?>
                        <option value="<?php echo $puesto['idPuesto']; ?>"><?php echo $puesto['nombre']; ?></option>
                    <?php endforeach ?>
                </select>
            </fieldset>

            <!-- botton amarillo -->
            <div class="boton-verde-center">
                <input type="submit" value="Enviar" class="boton-verde">
            </div>
        </form>
    </div>
</main>
<!-- footer -->
<footer>
    <p>Coorporativo<span> Naercris</span> S.A. de C.V. Todos los Derechos Reservados &copy;</p>
</footer>

<!-- mandamos a llmar js -->
<script src=" js/script.js"></script>
</body>

</html>

<?php

mysqli_close($conexion);

?>