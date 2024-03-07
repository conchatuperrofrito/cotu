<?php
include("../../conneccion/conection.php");

$nroCotizacion = $_REQUEST['nroCotizacion'];

$query = "DELETE FROM cotizacion WHERE nroCotizacion='$nroCotizacion' ";
$resultado = $conexion->query($query);

if ($resultado) {
    header("Location: viewTable.php");
} else {
    echo "no se elimino";
}

?>