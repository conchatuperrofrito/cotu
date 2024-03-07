<?php
include("../../conneccion/dbUnamba.php");
session_start();
$fechaActual = date('Y-m-d H:i:s');
$admin_id = $_SESSION['dni'];
if (!isset($admin_id)) {
   header('location:admin_login.php');
}
if (isset($_POST['regresar'])) {
   header('location:../dashboard.php');

   exit(); // Asegura que no se procese nada más después de la redirección
}
if (isset($_POST['submit'])) {
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $tipo = $_POST['tipo'];
   // $tipo = filter_var($tipo, FILTER_SANITIZE_STRING);
   $telefono = $_POST['telefono'];
   // $telefono = filter_var($telefono, FILTER_SANITIZE_STRING);
   $estado = $_POST['estado'];
   // $estado = filter_var($estado, FILTER_SANITIZE_STRING);
   $correo = $_POST['correo'];
   $correo = filter_var($correo, FILTER_SANITIZE_STRING);

   $update_profile_name = $conn->prepare("UPDATE `tadmin` SET tadmin_nombre = ? WHERE tadmin_dni = ?");
   $update_profile_name->execute([$name, $admin_id]);
   $update_profile_tipo = $conn->prepare("UPDATE `tadmin` SET tadmin_tipo = ? WHERE tadmin_dni = ?");
   $update_profile_tipo->execute([$tipo, $admin_id]);
   $update_profile_telefono = $conn->prepare("UPDATE `tadmin` SET tadmin_telefono = ? WHERE tadmin_dni = ?");
   $update_profile_telefono->execute([$telefono, $admin_id]);
   $update_profile_estado = $conn->prepare("UPDATE `tadmin` SET tadmin_estado = ? WHERE tadmin_dni = ?");
   $update_profile_estado->execute([$estado, $admin_id]);
   $update_profile_correo = $conn->prepare("UPDATE `tadmin` SET tadmin_correo = ? WHERE tadmin_dni = ?");
   $update_profile_correo->execute([$correo, $admin_id]);

   $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
   $prev_pass = $_POST['prev_pass'];
   $old_pass = $_POST['old_pass'];
   $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
   $new_pass = $_POST['new_pass'];
   $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
   $confirm_pass = $_POST['confirm_pass'];
   $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);

   if ($old_pass == $empty_pass) {
      $message[] = 'Por favor ingrese la contraseña anterior!';
   } elseif ($old_pass != $prev_pass) {
      $message[] = '¡La contraseña anterior no coincide!';
   } elseif ($new_pass != $confirm_pass) {
      $message[] = '¡Confirmación de contraseña no coincide!';
   } else {
      if ($new_pass != $empty_pass) {
         $update_admin_pass = $conn->prepare("UPDATE `tadmin` SET tadmin_password = ? WHERE tadmin_dni = ?");
         $update_admin_pass->execute([$confirm_pass, $admin_id]);
         $message[] = 'actualización corecta happy haching';

      } else {
         $message[] = 'Introduzca una nueva contraseña';
      }

   }
   ?>
   <script>

      function confirmarRedireccion() {
         // Muestra el cuadro de confirmación
         var respuesta = confirm("actualización exitosa happy haching");

         // Si el usuario hizo clic en "Aceptar", redirige a index.php
         if (respuesta) {
            // Realiza la redirección usando el objeto location
            location.href = '../dashboard.php';
         } else {
            // Si el usuario hizo clic en "Cancelar" o cerró la ventana de confirmación
            // alert("Has cancelado la redirección.");
         }
      }
      confirmarRedireccion();

   </script>
   <?php

   ////////////////INSPECTION(START)////////////////////
   $select_products1 = $conn->prepare("SELECT * FROM `tadmin` WHERE tadmin_dni = ?");
   $select_products1->execute([$admin_id]);
   while ($row = $select_products1->fetch(PDO::FETCH_ASSOC)) {
      $insert_control1 = $conn->prepare("INSERT INTO `tcontrol`(Columnid, Columninspeccion, Columnname, Columntimes,dniUser) VALUES (?,?,?,?,?)");
      $insert_control1->execute(['0', 'ACTUALIZO SU PERFIL', $row['tadmin_nombre'], $fechaActual, $row['tadmin_dni'],]);
   }
   ////////////////INSPECTION(FINISH)////////////////////   exit();
} else {
   echo "no hay interferencia de red";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update profile</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="admin_style.css">

</head>

<body>



   <section class="form-container">
      <?php
      $select_profile = $conn->prepare("SELECT * FROM `tadmin` WHERE tadmin_dni = ?");
      $select_profile->execute([$admin_id]);
      $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
      ?>
      <form action="" method="post">
         <h3>actualizar perfil usuario</h3>
         <h3>(verifique los datos antes de actualizar)</h3>

         <input type="hidden" name="prev_pass" value="<?= $fetch_profile['tadmin_password']; ?>">
         <h1 class="nombresUpdate">DNI</h1>
         <input type="text" value="<?= $fetch_profile['tadmin_dni']; ?>" class="box" readonly>

         <h1 class="nombresUpdate">NOMBRE</h1>
         <input type="text" name="name" value="<?= $fetch_profile['tadmin_nombre']; ?>" required
            placeholder="ingresa tu nombre" maxlength="20" class="box">
         <h1 class="nombresUpdate">ESTADO</h1>
         <select class="box" name="estado" id="validationCustom02">
            <!-- <option selected value="MostrarTodo">Mostrar Todo</option> -->
            <option value="activo">activo</option>
            <option value="inactivo">inactivo</option>
         </select>
         <h1 class="nombresUpdate">CELULAR</h1>
         <input type="number" name="telefono" value="<?= $fetch_profile['tadmin_telefono']; ?>" required
            placeholder="enter your username" maxlength="20" class="box"
            oninput="this.value = this.value.replace(/\s/g, '')">
         <h1 class="nombresUpdate">TIPO</h1>
         <select class="box" name="tipo" id="validationCustom02">
            <option value="administrador">administrador</option>
            <option value="capturista">capturista</option>
         </select>
         <h1 class="nombresUpdate">CORREO</h1>
         <input type="text" name="correo" value="<?= $fetch_profile['tadmin_correo']; ?>" required
            placeholder="ingresa tu correo" maxlength="20" class="box"
            oninput="this.value = this.value.replace(/\s/g, '')">
         <h1 class="nombresUpdate">CONTRASEÑA</h1>
         <input type="password" name="old_pass" placeholder="ingrese su antigua contraseña" maxlength="20" class="box"
            oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="password" name="new_pass" placeholder="Ingrese su nueva contraseña" maxlength="20" class="box"
            oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="password" name="confirm_pass" placeholder="Confirma su nueva contraseña" maxlength="20"
            class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="submit" value="regresar" class="btn" name="regresar">

         <input type="submit" value="actualizar" class="btn" name="submit">

      </form>
   </section>
   <script src="../js/admin_script.js"></script>
</body>

</html>