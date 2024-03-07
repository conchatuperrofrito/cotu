<?php
include '../../conneccion/dbUnamba.php';
session_start();

////////SONA HORARIA////////////
date_default_timezone_set('UTC');
$fechaActual = date('Y-m-d H:i:s');
////////SONA HORARIA////////////

$admin_id = $_SESSION['dni'];

if (isset($_GET['idDni'])) {
    $delete_dni = $_GET['idDni'];
    $delete_admins = $conn->prepare("DELETE FROM `tadmin` WHERE tadmin_dni = ?");
    $delete_admins->execute([$delete_dni]);
    ////////////////INSPECTION(START)////////////////////
    $select_products1 = $conn->prepare("SELECT * FROM `tadmin` WHERE tadmin_dni = ?");
    $select_products1->execute([$admin_id]);
    while ($row = $select_products1->fetch(PDO::FETCH_ASSOC)) {
        $insert_control1 = $conn->prepare("INSERT INTO `tcontrol`(Columnid, Columninspeccion, Columnname, Columntimes,dniUser) VALUES (?,?,?,?,?)");
        $insert_control1->execute(['0', 'ELIMINO AL USUARIO :  ' . $admin_id . ' ->', $row['tadmin_nombre'], $fechaActual, $row['tadmin_dni'],]);
    }
    ////////////////INSPECTION(FINISH)////////////////////   exit();

    header('location:../dashboard.php');
}
?>