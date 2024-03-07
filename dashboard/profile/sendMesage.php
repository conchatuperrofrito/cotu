<?php
include("../../conneccion/dbUnamba.php");
session_start();
$admin_id = $_SESSION['dni'];
if (!isset($admin_id)) {
    header('location:admin_login.php');
}
////////SONA HORARIA////////////
date_default_timezone_set('UTC');
$fechaActual = date('Y-m-d H:i:s');
////////SONA HORARIA////////////



if (isset($_POST['send'])) {
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $msg = $_POST['msg'];
    $msg = filter_var($msg, FILTER_SANITIZE_STRING);

    $insert_message = $conn->prepare("INSERT INTO `messages`(user_id, name, message,id,mensageFehca) VALUES(?,?,?,?,?)");
    $insert_message->execute([$admin_id, $name, $msg, '', $fechaActual]);
    $message[] = 'mensaje enviado exitosamente!';
    header('location:../dashboard.php');


}
?>