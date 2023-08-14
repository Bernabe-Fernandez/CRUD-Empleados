<?php
//llamamos a la conexion
require_once '../config/conexion.php';
$conexion = conectar();
//llamaos la funcionde consuktar puestos
require '../templates/consultarPuestos.php';

//datos a consultar dentro de la bd
$columns = ['idEmpleado', 'nombre', 'apellidoPaterno', 'apellidoMaterno', 'fechaNacimiento', 'rfc', 'fechaIngreso',  'genero', 'estatus',  'domicilio',  'telefono', 'fotografia', 'puesto'];
//table donde se realiza la consulta
$table = "empleado";
$id = "idEmpleado";
$puesto = "";

//recibir el filtro que vamos a aplicar, preevio a eso se limpia el dato, para evitar entrada de datos incorrectos
$campo = isset($_POST['campo']) ? $conexion->real_escape_string($_POST['campo']) : null;
//$campo = "Bernabe";
//creacion del filtro mediante el uso de un where
$condicion = '';

//evaluamos que campo no venga vacio
if ($campo != null) {
    $condicion = $condicion . " (";
    //se genera una variable que guarde el numero de columnas que estan en el arreglocolumns
    $cont = count($columns);
    //se recorre el arrego de columnas para ir generando el where especifico para cada una de las condiciones y filtros
    for ($i = 0; $i < $cont; $i++) {
        $condicion .= $columns[$i] . " LIKE '%" . $campo . "%' OR ";
    }
    //eliminar el ultimo OR del WHERE mediante una funcion de remplazo
    $condicion = substr_replace($condicion, "", -3);
    $condicion .= ")";
}
//agregamos un limit que nos ayude a delimitar el numero de registros que se jalaran a la tabla
$limit = isset($_POST['registros']) ? $conexion->real_escape_string($_POST['registros']) : 10;
//recibimos el valor de la pagina actual desde la funciond e JS
$pagina = isset($_POST['pagina']) ? $conexion->real_escape_string($_POST['pagina']) : 0;
//evaluamos que el valor de pagina sea diferente de 0
if (!$pagina) {
    $inicio = 0;
    $pagina = 1;
} else {
    $inicio = ($pagina - 1) * $limit;
}
$where = "WHERE estatus = 1";
if ($condicion !== "") {
    $where .= " AND (" . $condicion . ")";
}

$sqlLimit = "LIMIT $inicio, $limit";

//creacion del query para seleccionar mediante el uso de implode() para convertir un arreglo en string y mandar a llamar los datos necesarios
$querySelect = "SELECT " . implode(', ', $columns) . "
FROM $table $where $sqlLimit";
//ejecutar el query
$resultado = mysqli_query($conexion, $querySelect);
//obtener el numero de filas
$num_rows = mysqli_num_rows($resultado);
//consulta de los nombres de los puestos
$puestos = puestos($conexion);



//consulta para obtener el total de registros filtrados
$sqlFiltro = "SELECT FOUND_ROWS()";
//ejecutamos la sentencia sql
$resFiltro = mysqli_query($conexion, $sqlFiltro);
//extraemos en la variable todo el arreglo que obtiene la consulta
$row_filtro = mysqli_fetch_array($resFiltro);
//obtenemos la primer fila y columna
$totalFiltro = $row_filtro[0];

//consulta para obtener el total de registros
$sqlTotal = "SELECT count($id) FROM $table";
//ejecutamos la sentencia sql
$resTotal = mysqli_query($conexion, $sqlTotal);
//extraemos en la variable todo el arreglo que obtiene la consulta
$row_total = mysqli_fetch_array($resTotal);

//obtenemos la primer fila y columna
$totalRegistros = $row_total[0];

//arreglo para mostrar los resultados
$output = [];
//creamos un primer indice en el arreglo
$output['totalRegistros'] = $totalRegistros;
$output['totalFiltro'] = $totalFiltro;
$output['data'] = '';
$output['paginacion'] = '';

if ($num_rows > 0) {
    while ($row = mysqli_fetch_assoc($resultado)) {
        $output['data'] .= '<tr>';
        $output['data'] .= '<td>' . $row['idEmpleado'] . '</td>';
        $output['data'] .= '<td>' . $row['nombre'] . '</td>';
        $output['data'] .= '<td>' . $row['apellidoPaterno'] . '</td>';
        $output['data'] .= '<td>' . $row['apellidoMaterno'] . '</td>';
        $output['data'] .= '<td>' . $row['fechaNacimiento'] . '</td>';
        $output['data'] .= '<td>' . $row['rfc'] . '</td>';
        $output['data'] .= '<td>' . $row['fechaIngreso'] . '</td>';
        $output['data'] .= '<td>' . $row['genero'] . '</td>';
        $output['data'] .= '<td>' . $row['domicilio'] . '</td>';
        $output['data'] .= '<td>' . $row['telefono'] . '</td>';
        $output['data'] .= '<td><img class="imagen" src="/SistemaCrud/imagenes/' . $row['fotografia'] . '"></td>';
        
        //evaluamos que el puesto coincida con el id de los puestos y mostramos el nombre
        $nombrePuesto = "";
        mysqli_data_seek($puestos, 0); // Reiniciar el puntero del conjunto de resultados de puestos
        while($puesto = mysqli_fetch_assoc($puestos)){
            if ($row['puesto'] == $puesto['idPuesto']) {
                $nombrePuesto = $puesto['nombre'];
                break;
            }
        }
        $output['data'] .= '<td>' . $nombrePuesto . '</td>';
        $estatus = "";
        if ($row['estatus'] == 1) {
            $estatus = "Activo";
        }
        $output['data'] .= '<td>' . $estatus . '</td>';
        $output['data'] .= '<td><a href="actualizarEmp.php?id=' . $row['idEmpleado'] . '" class="boton-editar-block">Editar</a>
        <a href="includes/crud/deleteEmpleados.php?id=' . $row['idEmpleado'] . '" class="boton-eliminar-block">Eliminar</a></td>';
        $output['data'] .= '<td></td>';
        $output['data'] .= '</tr>';
    }
} else {
    $output['data'] .= '<tr>';
    $output['data'] .= '<td colspan="5">Sin Resultados</td>';
    $output['data'] .= '</tr>';
}

//procedimiento para realizar la paginacion
if ($output['totalRegistros'] > 0) {
    //la funcion ceil redondea asi arriba para obtener resultados enteros
    $totalPaginas = ceil($output['totalRegistros'] / $limit);

    $output['paginacion'] .= '<nav>';
    $output['paginacion'] .= '<ul class=pagination>';

    $numeroInicio = 1;
    if (($pagina - 4) > 1) {
        $numeroInicio = $pagina - 4;
    }

    $numeroFin = $numeroInicio + 9;
    if ($numeroFin > $totalPaginas) {
        $numeroFin = $totalPaginas;
    }


    for ($i = $numeroInicio; $i <= $numeroFin; $i++) {
        $output['paginacion'] .= '<li class="page-item"><a class="page-link" href="#" onclick="getData(' . $i . ')">' . $i . '</a></li>';
    }
    $output['paginacion'] .= '</ul>';
    $output['paginacion'] .= '</ul>';
}

mysqli_close($conexion);

echo json_encode($output, JSON_UNESCAPED_UNICODE);
