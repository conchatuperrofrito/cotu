<?php
require '../conneccion/config.php';
$resultado = null;

/* Un arreglo de las columnas a mostrar en la tabla */
// $columns = ['nroCotizacion ', 'fechaEntrega', 'descripcion', 'estado', 'anio'];
$columns = ['nroCotizacion', 'cotizacion_tipo', 'dependencia', 'descripcion', 'fechaEntrega', 'cotizacion_anexo4', 'cotizacion_anexo2', 'cotizacion_anexo3', 'pdfCot', 'estado'];
$columnsa = ['nroCotizacion', 'cotizacion_tipo', 'dependencia', 'descripcion', 'fechaEntrega', 'cotizacion_anexo4', 'cotizacion_anexo2', 'cotizacion_anexo3', 'pdfCot', 'estado'];
$columnsb = ['nroCotizacion', 'cotizacion_tipo', 'dependencia', 'descripcion', 'fechaEntrega', 'cotizacion_anexo4', 'cotizacion_anexo2', 'cotizacion_anexo3', 'pdfCot', 'estado'];

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
$output['cot1'] = '';
$output['cot2'] = '';
$output['cot3'] = '';
$output['cot4'] = '';
$output['fechaPasada'] = '';

// $num_rows = 0;ç
if ($num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {

        $claseFechaPasada = (strtotime($row['fechaEntrega']) < strtotime(date('Y-m-d'))) ? 'fecha-pasada' : '';

        $name1;
        if (empty($row['pdfCot'])) {
            $name1 = 'no';
            $output['cot1'] = $name1;
        }
        $name2;
        // Verifica si el campo cotizacion_anexo2 no está vacío
        if (empty($row['cotizacion_anexo2'])) {
            $name2 = 'no';
            $output['cot2'] = $name2;
        }
        $name3;
        // Verifica si el campo cotizacion_anexo3 no está vacío
        if (empty($row['cotizacion_anexo3'])) {
            $name3 = 'no';
            $output['cot3'] = $name3;
        }
        $name4;

        // Verifica si el campo cotizacion_anexo4 no está vacío
        if (empty($row['cotizacion_anexo4'])) {
            $name4 = 'no';
            $output['cot4'] = $name4;
        }
        $output['data'] .= '<tr class="data-row ' . $claseFechaPasada . '" style=" height: 100px;">';
        $output['data'] .= '<td style=" width: 100px;">' . $row['nroCotizacion'] . '</td>';
        $output['data'] .= '<td style=" width: 100px;">' . $row['cotizacion_tipo'] . '</td>';
        $output['data'] .= '<td style=" width: 200px;">' . $row['dependencia'] . '</td>';
        $output['data'] .= '<td style="    text-align: left;">' . $row['descripcion'] . '</td>';
        $output['data'] .= '<td style=" width: 100px;">' . $row['estado'] . '</td>';

        $output['data'] .= '<td style=" width: 100px;">' . $row['fechaEntrega'] . '</td>';

        $output['data'] .= '<td style=" width: 100px;">
        <button type="button" class="btn btn-primary btnEdit" data-toggle="modal" data-target="#exampleModal' . $row['nroCotizacion'] . '"><i class="ri-newspaper-fill"></i>
  DESCARGAR
</button>
<br> 
<a href="Cotizacion/Admin/formCotizacion.php?id=' . $row['nroCotizacion'] . '"
class="btn btn-secondary btnEdit"><i class="ri-newspaper-fill"></i> ENVIAR</a>

<style>
.btnEdit{
    
   
        padding: 0px;
        border-radius: 0px;

        margin: 5px;
       
        width: 160px;
       
}
.btn-secondary{
    background-color: #23BF08;
}
.ul {
    list-style-type: none;
    padding: 0;
}

.li {
    margin: 2px 0;
    padding: 5px;
    border: 1px solid #ddd;
    cursor: pointer;
    transition: background-color 0.3s;
}

.li:hover {
    background-color: #f5f5f5;
}
</style>
<!-- Modal -->
<div class="modal fade" id="exampleModal' . $row['nroCotizacion'] . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">ANEXOS</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
<ul  id="ul">
<li class="li' . $row['pdfCot'] . ' "><a href="Cotizacion/conection/carpeta_pdf/' . $row['pdfCot'] . '  "target="_blank">descargar archivo 1 </a></li>
<li class="li' . $row['cotizacion_anexo2'] . '" ><a href="Cotizacion/conection/carpeta_pdf/' . $row['cotizacion_anexo2'] . ' "target="_blank">descargar archivo 2</a></li>
<li class="li' . $row['cotizacion_anexo3'] . '" ><a href="Cotizacion/conection/carpeta_pdf/' . $row['cotizacion_anexo3'] . ' "target="_blank">descargar archivo 3</a></li>
<li class="li' . $row['cotizacion_anexo4'] . '" ><a href="Cotizacion/conection/carpeta_pdf/' . $row['cotizacion_anexo4'] . ' "target="_blank">descargar archivo 4</a></li>

</ul>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>

  
           <a href="Cotizacion/Admin/formCotizacion.php?id=' . $row['nroCotizacion'] . '"
            class="btn btn-secondary" style="BACKGROUND: BLUE;">ENVIAR PROPUESTA</a>
         </div>
    </div>
  </div>
</div>';

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
?>