<!DOCTYPE html>
<html>
<head>
    <title>Cargar PDF</title>
</head>
<body>
    
<ul>
        <?php
        include("../../conneccion/conection.php");
        $query = "SELECT * FROM cotizacion";
        $resultado = $conexion->query($query);

        while ($row = $resultado->fetch_assoc()) {
            echo '<li>';
            echo '<a href="' . $row['pdfCot'] . '" target="_blank">' . $row['nroCotizacion'] . ' - ' . $row['descripcion'] . '</a>';
            echo '</li>';
        }
        ?>
</ul>
</body>
</html>
