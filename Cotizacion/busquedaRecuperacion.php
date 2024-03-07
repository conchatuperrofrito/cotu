<?php
require 'config.php';

/* Un arreglo de las columnas a mostrar en la tabla */
$columns = ['nroCotizacion ', 'fechaEntrega', 'descripcion', 'estado', 'anio'];
$columnsa = ['nroCotizacion ', 'fechaEntrega', 'descripcion', 'estado', 'anio'];
$columnsb = ['nroCotizacion ', 'fechaEntrega', 'descripcion', 'estado', 'anio'];
/* Nombre de la tabla */
$table = "cotizacion";

$id = 'nroCotizacion ';

// exist el indice campo en la matriz $_POST SEGUIE , SINO SERA NULL
// En resumen, la expresión ternaria completa asigna a la variable $campo el valor escapado de $_POST['campo'] si este último está presente,
// y null si no lo está. Este tipo de estructura se utiliza a menudo para manejar de manera segura los datos recibidos del usuario,
// especialmente cuando se trata de datos que se utilizarán en consultas a bases de datos para prevenir posibles ataques.


$campo = isset($_POST['campo']) ? $conn->real_escape_string($_POST['campo']) : null;

$optiona = isset($_POST['optiona']) ? $conn->real_escape_string($_POST['optiona']) : null;
$optionb = isset($_POST['optionb']) ? $conn->real_escape_string($_POST['optionb']) : null;

// 

/* Filtrado */
$where = '';
// SELECT * FROM empleados WHERE( nombre LIKE '%Chirstian%' OR apellido LIKE '%Chirstian%')
if ($campo != null) {
    $where = "WHERE (";
    // $cont=5 
    $cont = count($columns);
    // 5 VECES 
    for ($i = 0; $i < $cont; $i++) {
        $where .= $columns[$i] . " LIKE '%" . $campo . "%' OR ";
    }
    $where = substr_replace($where, "", -3);

    $where .= ")";
}
// $where = '';
if ($optiona != null) {
    $where = "WHERE (";
    // $cont=5 
    $conta = count($columns);
    // 5 VECES 
    for ($ia = 0; $ia < $conta; $ia++) {
        $where .= $columns[$ia] . " LIKE '%" . $optiona . "%' OR ";
    }
    $where = substr_replace($where, "", -3);

    $where .= ")";
}

if ($optionb != null) {
    $where = "WHERE (";
    // $cont=5 
    $contb = count($columns);
    // 5 VECES 
    for ($ib = 0; $ib < $contb; $ib++) {
        $where .= $columns[$ib] . " LIKE '%" . $optionb . "%' OR ";
    }
    $where = substr_replace($where, "", -3);

    $where .= ")";
}

// if ($campo != null) {
//     $where = "WHERE (";
//     // $cont=5 
//     $cont = count($columns);
//     // 5 VECES 
//     for ($i = 0; $i < $cont; $i++) {
//         $where .= $columns[$i] . " LIKE '%" . $campo . "%' OR ";
//     }
//     $where = substr_replace($where, "", -3);

//     $where .= ")";
// } 

// if ($campo != null) {
//     $where = "WHERE (";
//     // $cont=5 
//     $cont = count($columns);
//     // 5 VECES 
//     for ($i = 0; $i < $cont; $i++) {
//         $where .= $columns[$i] . " LIKE '%" . $campo . "%' OR ";
//     }
//     $where = substr_replace($where, "", -3);

//     $where .= ")";
// } 


// if ($campo != null) {
//     $where = "WHERE (";
//     // $cont=5 
//     $cont = count($columns);
//     // 5 VECES 
//     for ($i = 0; $i < $cont; $i++) {
//         $where .= $columns[$i] . " LIKE '%" . $campo . "%' OR ";
//     }
//     $where = substr_replace($where, "", -3);

//     $where .= ")";
// } 




/* Limit */
$limit = isset($_POST['registros']) ? $conn->real_escape_string($_POST['registros']) : 10;
$pagina = isset($_POST['pagina']) ? $conn->real_escape_string($_POST['pagina']) : 0;

if (!$pagina) {
    $inicio = 0;
    $pagina = 1;
} else {
    $inicio = ($pagina - 1) * $limit;
}

$sLimit = "LIMIT $inicio , $limit";

$sOrder = "";
if (isset($_POST['orderCol'])) {
    $orderCol = $_POST['orderCol'];
    $oderType = isset($_POST['orderType']) ? $_POST['orderType'] : 'asc';

    $sOrder = "ORDER BY " . $columns[intval($orderCol)] . ' ' . $oderType;
}


/* Consulta */
$sql = "SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $columns) . "
FROM $table
$where
$sOrder
$sLimit";
$resultado = $conn->query($sql);
$num_rows = $resultado->num_rows;

/* Consulta para total de registro filtrados */
$sqlFiltro = "SELECT FOUND_ROWS()";
$resFiltro = $conn->query($sqlFiltro);
$row_filtro = $resFiltro->fetch_array();
$totalFiltro = $row_filtro[0];

/* Consulta para total de registro filtrados */
$sqlTotal = "SELECT count($id) FROM $table ";
$resTotal = $conn->query($sqlTotal);
$row_total = $resTotal->fetch_array();
$totalRegistros = $row_total[0];

/* Mostrado resultados */
$output = [];
$output['totalRegistros'] = $totalRegistros;
$output['totalFiltro'] = $totalFiltro;
$output['data'] = '';
$output['paginacion'] = '';


// $num_rows = 0;ç
if ($num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $output['data'] .= '<tr class="data-row">';
        $output['data'] .= '<td>' . $row['nroCotizacion'] . '</td>';
        // $output['data'] .= '<td>' . $row['c'] . '</td>';
        $output['data'] .= '<td>' . $row['estado'] . '</td>';
        // $output['data'] .= '<td>' . $row['fechaEntrega'] . '</td>';
        // $output['data'] .= '<td>' . $row['fecha_ingreso'] . '</td>';
        // $output['data'] .= '<td><a class="btn btn-warning btn-sm" href="editar.php?id=' . $row['nroCotizacion '] . '">Editar</a></td>';
        // $output['data'] .= "<td><a class='btn btn-danger btn-sm' href='elimiar.php?id=" . $row['nroCotizacion '] . "'>Eliminar</a></td>";
        $output['data'] .= '</tr>';
    }
} else {
    $output['data'] .= '<tr>';
    $output['data'] .= '<td colspan="7">Sin resultados</td>';
    $output['data'] .= '</tr>';
}

if ($output['totalRegistros'] > 0) {
    $totalPaginas = ceil($output['totalRegistros'] / $limit);

    $output['paginacion'] .= '<nav>';
    $output['paginacion'] .= '<ul class="pagination">';

    $numeroInicio = 1;

    if (($pagina - 4) > 1) {
        $numeroInicio = $pagina - 4;
    }

    $numeroFin = $numeroInicio + 9;

    if ($numeroFin > $totalPaginas) {
        $numeroFin = $totalPaginas;
    }

    for ($i = $numeroInicio; $i <= $numeroFin; $i++) {
        if ($pagina == $i) {
            $output['paginacion'] .= '<li class="page-item active"><a class="page-link" href="#">' . $i . '</a></li>';
        } else {
            $output['paginacion'] .= '<li class="page-item"><a class="page-link" href="#" onclick="nextPage(' . $i . ')">' . $i . '</a></li>';
        }
    }

    $output['paginacion'] .= '</ul>';
    $output['paginacion'] .= '</nav>';
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);


