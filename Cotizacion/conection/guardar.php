<?php
include("../../conneccion/dbUnamba.php");
session_start();
$fechaActual = date('Y-m-d H:i:s');
$admin_id = $_SESSION['dni'];
if (!isset($admin_id)) {
    header('location:../../dashboard/admin_login.php');
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nroCotizacion"])) {
    $nroCotizacion = $_POST['nroCotizacion'];
    $descripcion = $_POST['descripcion'];
    $tipo = $_POST['tipo'];
    $fechaEntrega = $_POST['fechaEntrega'];
    $fechaSuvida = $_POST['fechaSuvida'];
    $horaSuvida = $_POST['horaSuvida'];
    $dependencia = $_POST['dependencia'];
    //
    $pdfFilename = $_FILES['pdfFile']['name'];
    $pdfFilename = filter_var($pdfFilename, FILTER_SANITIZE_STRING);
    $pdfFilename_size_0 = $_FILES['pdfFile']['size'];
    $pdfFileTmp0 = $_FILES['pdfFile']['tmp_name'];
    //
    $pdfFilenamedos = $_FILES['pdfFiledos']['name'];
    $pdfFilenamedos = filter_var($pdfFilenamedos, FILTER_SANITIZE_STRING);
    $pdfFilenamedos_size_1 = $_FILES['pdfFiledos']['size'];
    $pdfFileTmp1 = $_FILES['pdfFiledos']['tmp_name'];
    //
    $pdfFilenametres = $_FILES['pdfFileThree']['name'];
    $pdfFilenametres = filter_var($pdfFilenametres, FILTER_SANITIZE_STRING);
    $pdfFilenametres_size_2 = $_FILES['pdfFileThree']['size'];
    $pdfFileTmp2 = $_FILES['pdfFileThree']['tmp_name'];
    //
    $pdfFilenamecuatro = $_FILES['pdfFilefour']['name'];
    $pdfFilenamecuatro = filter_var($pdfFilenamecuatro, FILTER_SANITIZE_STRING);
    $pdfFilenamecuatro_size_3 = $_FILES['pdfFilefour']['size'];
    $pdfFileTmp3 = $_FILES['pdfFilefour']['tmp_name'];
    //



    $select_products1 = $conn->prepare("SELECT * FROM `cotizacion` WHERE nroCotizacion = ?");
    $select_products1->execute([$nroCotizacion]);
    $fetch_profile1 = $select_products1->fetch(PDO::FETCH_ASSOC);

    $select_products2 = $conn->prepare("SELECT * FROM `cotizacion` WHERE pdfCot = ? or cotizacion_anexo2 = ? or cotizacion_anexo3 = ? or cotizacion_anexo4=?");
    $select_products2->execute([$pdfFilename, $pdfFilename, $pdfFilename, $pdfFilename]);
    $fetch_profile2 = $select_products2->fetch(PDO::FETCH_ASSOC);

    $select_products3 = $conn->prepare("SELECT * FROM `cotizacion` WHERE cotizacion_anexo2 = ? or pdfCot = ? or cotizacion_anexo3 = ? or  cotizacion_anexo4=? ");
    $select_products3->execute([$pdfFilenamedos, $pdfFilename, $pdfFilename, $pdfFilename]);
    $fetch_profile3 = $select_products3->fetch(PDO::FETCH_ASSOC);

    $select_products4 = $conn->prepare("SELECT * FROM `cotizacion` WHERE cotizacion_anexo2 = ? or pdfCot = ? or cotizacion_anexo3 = ? or  cotizacion_anexo4=?");
    $select_products4->execute([$pdfFilenametres, $pdfFilenametres, $pdfFilenametres, $pdfFilenametres]);
    $fetch_profile4 = $select_products4->fetch(PDO::FETCH_ASSOC);

    $select_products5 = $conn->prepare("SELECT * FROM `cotizacion` WHERE cotizacion_anexo2 = ? or pdfCot = ? or cotizacion_anexo3 = ? or  cotizacion_anexo4=?");
    $select_products5->execute([$pdfFilenamecuatro, $pdfFilenamecuatro, $pdfFilenamecuatro, $pdfFilenamecuatro]);
    $fetch_profile5 = $select_products5->fetch(PDO::FETCH_ASSOC);

    if ($select_products1->rowCount() > 0 and $fetch_profile1['nroCotizacion'] != '') {
        echo '<script>
        var mensaje = "la cotizacion ya esta registrada.";
        if (confirm(mensaje)) {
            window.location.href = "../../dashboard/dashboard.php";
        }
      </script>';
        exit;
    }
    if ($select_products2->rowCount() > 0 and $fetch_profile2['pdfCot'] != '') {
        echo '<script>
        var mensaje = "nombre del archivo 1 , ya existe";
        if (confirm(mensaje)) {
            window.location.href = "../../dashboard/dashboard.php";
        }
      </script>';
        exit;
    }

    if ($select_products3->rowCount() > 0 and $fetch_profile3['cotizacion_anexo2'] != '') {
        echo '<script>
        var mensaje = "nombre del archivo 2 , ya existe";
        if (confirm(mensaje)) {
            window.location.href = "../../dashboard/dashboard.php";
        }
      </script>';
        exit;
    }
    if ($select_products4->rowCount() > 0 and $fetch_profile4['cotizacion_anexo3'] != '') {
        echo '<script>
        var mensaje = "nombre del archivo 3 , ya existe";
        if (confirm(mensaje)) {
            window.location.href = "../../dashboard/dashboard.php";
        }
      </script>';
        exit;
    }
    if ($select_products5->rowCount() > 0 and $fetch_profile5['cotizacion_anexo4'] != '') {
        echo '<script>
        var mensaje = "nombre del archivo 4 , ya existe";
        if (confirm(mensaje)) {
            window.location.href = "../../dashboard/dashboard.php";
        }
      </script>';
        exit;
    }
    //
    $inforTable_folder_0 = 'carpeta_pdf/' . $pdfFilename;
    $inforTable_folder_1 = 'carpeta_pdf/' . $pdfFilenamedos;
    $inforTable_folder_2 = 'carpeta_pdf/' . $pdfFilenametres;
    $inforTable_folder_3 = 'carpeta_pdf/' . $pdfFilenamecuatro;

    // Insertar datos en la base de datos
    $query = "INSERT INTO cotizacion (nroCotizacion, descripcion, cotizacion_tipo, fechaEntrega, fechaSuvida, dependencia, pdfCot,cotizacion_anexo2,cotizacion_anexo3,cotizacion_anexo4,estado) VALUES ('$nroCotizacion', '$descripcion', '$tipo', '$fechaEntrega', '$fechaSuvida.:.$horaSuvida', '$dependencia', '$pdfFilename', '$pdfFilenamedos', '$pdfFilenametres', '$pdfFilenamecuatro','activo')";
    $resultado = $conn->query($query);
    if ($pdfFilename_size_0 < 25000000 or $pdfFilenamedos_size_1 < 25000000 or $pdfFilenametres_size_2 < 25000000 or $pdfFilenamecuatro_size_3 < 25000000) {
        if ($resultado) {
            move_uploaded_file($pdfFileTmp0, $inforTable_folder_0);
            move_uploaded_file($pdfFileTmp1, $inforTable_folder_1);
            move_uploaded_file($pdfFileTmp2, $inforTable_folder_2);
            move_uploaded_file($pdfFileTmp3, $inforTable_folder_3);

            ////////////////INSPECTION(START)////////////////////
            $select_products = $conn->prepare("SELECT * FROM `tadmin` WHERE tadmin_dni = ?");
            $select_products->execute([$admin_id]);
            while ($row = $select_products->fetch(PDO::FETCH_ASSOC)) {
                $insert_control = $conn->prepare("INSERT INTO `tcontrol`(Columnid, Columninspeccion, Columnname, Columntimes,dniUser) VALUES (?,?,?,?,?)");
                $insert_control->execute(['0', 'LANZO LA  COTIZACION :' . $nroCotizacion, $row['tadmin_nombre'], $fechaActual, $row['tadmin_dni'],]);
            }
            ////////////////INSPECTION(FINISH)////////////////////

            header('Location: ../../dashboard/dashboard.php');
            exit;
        } else {
            $message[] = 'archivo muy pesado!';
            echo ($message3);
        }
    } else {
        echo "archivo muy pesado!";
    }
} else {
    echo "ahorror!";
    $message[] = 'ahorror!';
    ?>
    <script>     console.log(<?php $message[] = 'ahorror!'; ?>);
    </script>
    <?php
}
