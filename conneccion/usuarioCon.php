<?php
$conn = new mysqli("localhost", "u875102609_a", "unambaA1", "u875102609_a");
/* Creando una nueva conexión a la base de datos. */
// $conn = new mysqli("127.0.0.1:666", "root", "", "dbcotizacion");
/* Comprobando si hay un error de conexión. */
if ($conn->connect_error) {
    die('Error de conexion ' . $conn->connect_error);
}