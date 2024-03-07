<?php
// $conn = new mysqli("localhost", "u875102609_a", "unambaA1", "u875102609_a");
$conn = new mysqli("localhost:666", "root", "", "dbcotizacion");
if ($conn->connect_error) {
    die('Error de conexion ' . $conn->connect_error);
}
