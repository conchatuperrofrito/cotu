<?php
include("../../conneccion/conection.php");

// Recuperar los datos del formulario
$nroCotizacion = $_GET['nroCotizacion'];

$descripcion = $_POST['descripcion'];
$estado = $_POST['estado'];
$fechaEntrega = $_POST['fechaEntrega'];
$dependencia = $_POST['dependencia'];
$año = $_POST['año'];

// Cargar el nuevo archivo PDF si se proporcionó uno
if ($_FILES['pdfFile']['error'] === UPLOAD_ERR_OK) {
    $pdfFilename = $_FILES['pdfFile']['name'];
    $pdfFileTmp = $_FILES['pdfFile']['tmp_name'];
    $rutaCarpeta = "carpeta_pdf/";
    $rutaArchivo = $rutaCarpeta . $pdfFilename;

    if (move_uploaded_file($pdfFileTmp, $rutaArchivo)) {
        // Archivo PDF cargado correctamente, actualizar solo los campos relacionados sin modificar el número de cotización

        $queryActualizar = "UPDATE cotizacion SET descripcion='$descripcion', estado='$estado', fechaEntrega='$fechaEntrega', dependencia='$dependencia', año='$año', pdfCot='$rutaArchivo' WHERE nroCotizacion='$nroCotizacion'";

        $resultadoActualizar = $conexion->query($queryActualizar);

        if ($resultadoActualizar) {
            header("Location: viewTable.php"); // Redirigir a la página de visualización de cotizaciones actualizadas
        } else {
            echo "Error al actualizar los datos.";
        }
    } else {
        // Error al cargar el archivo PDF
        echo "Error al cargar el archivo PDF.";
    }
} else {
    // No se proporcionó un nuevo archivo PDF, actualizar solo los campos relacionados sin modificar el número de cotización

    $queryActualizar = "UPDATE cotizacion SET descripcion='$descripcion', estado='$estado', fechaEntrega='$fechaEntrega', dependencia='$dependencia', año='$año' WHERE nroCotizacion='$nroCotizacion'";

    $resultadoActualizar = $conexion->query($queryActualizar);

    if ($resultadoActualizar) {
        header("Location: viewTable.php"); // Redirigir a la página de visualización de cotizaciones actualizadas
    } else {
        echo "Error al actualizar los datos.";
    }
}
?>