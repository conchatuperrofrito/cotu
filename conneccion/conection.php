<?php
$conexion = new mysqli("localhost:666", "root", "", "dbcotizacion");
// $conexion = new mysqli("localhost", "u875102609_a", "unambaA1", "u875102609_a");
if ($conexion) {
    echo "->usted tiene buena conexion";
} else {
    echo "error de conexion";
}
