<!DOCTYPE html>
<html>
<head>
    <title>Visor de PDF</title>
</head>
<body>
    <?php
    if (isset($_GET['pdf'])) {
        $pdfFile = $_GET['pdf'];
        ?>
        <embed src="<?php echo $pdfFile; ?>" type="application/pdf" width="100%" height="600px" />
        <?php
    } else {
        echo "Archivo PDF no encontrado.";
    }
    ?>
</body>
</html>
