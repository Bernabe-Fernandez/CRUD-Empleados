<?php
//mandamos a llamar el header en nuestro index
require 'includes/app.php';
incluirTemplate('header');
$resultado = "";
if(isset($_GET['resultado'])){
    $resultado = $_GET['resultado'];
}
?>
<main class="main contenedor">
    <?php
        if($resultado == 1):
    ?>
        <div class="alerta exito" id="alerta1">
            Empleado Registrado<
        </div>
    <?php
        endif;
        if($resultado == 2):
    ?>
        <div class="alerta orange" id="alerta2">
            Empleado Actualizado
        </div>
    <?php
        endif;
        if($resultado == 3):
    ?>
        <div class="alerta error" id="alerta3">
            Empleado Eliminado
        </div>
    <?php
        endif;
    ?>    
    <h3>Lista de Empleados</h3>
    <form class="form-content" role="search">
        <div class="buscador">
            <input class="input-buscador" type="search" placeholder="Buscar" id="campo" aria-label="Search" title="buscador">
        </div>
        <div class="num-registros">
            <select name="num_registros" id="num_registros" class="input-select">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>
        </div>
    </form>
    <div class="contenedor-tabla">
        <table id="results" class="empleados">
            <thead>
                <tr>
                    <th scope="col" id="ColId">No. Empleado</th>
                    <th scope="col" id="ColNombre">Nombre</th>
                    <th scope="col" id="ColApellidoPat">Apellido Paterno</th>
                    <th scope="col" id="ColApellidoMat">Apellido Materno</th>
                    <th scope="col" id="ColNacimiento">Fecha de Nacimiento</th>
                    <th scope="col" id="ColRfc">RFC</th>
                    <th scope="col" id="ColIngreso">Fecha de Ingreso</th>
                    <th scope="col" id="ColGenero">Genero</th>
                    <th scope="col" id="ColDomicilio">Domicilio</th>
                    <th scope="col" id="ColTelefono">Telefono</th>
                    <th scope="col" id="ColFotografia">Fotografia</th>
                    <th scope="col" id="ColPuesto">Puesto</th>
                    <th scope="col" id="ColEstatus">Estatus</th>
                    <th scope="col" id="ColAcciones">Acciones</th>
                </tr>
            </thead>
            <tbody id="content">

            </tbody>
        </table>
    </div>
</main>
<!-- footer -->
<footer>
    <p>Coorporativo<span> Naercris</span> S.A. de C.V. Todos los Derechos Reservados &copy;</p>
</footer>
<!-- mandamos a llmar js -->
<script src=" js/read.js"></script>
<script src=" js/script.js"></script>
</body>

</html>