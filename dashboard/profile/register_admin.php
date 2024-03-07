<?php

include '../../conneccion/dbUnamba.php';
session_start();
$fechaActual = date('Y-m-d H:i:s');
$admin_id = $_SESSION['dni'];
if (!isset($admin_id)) {
   header('location:admin_login.php');
}
echo ($fechaActual . 'sin interferencias detectadas');


if (isset($_POST['submit'])) {
   $dniuser = $_POST['dniuser'];
   $dniuser = filter_var($dniuser, FILTER_SANITIZE_STRING);
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $estado = $_POST['estado'];
   $telefono = $_POST['telefono'];
   $telefono = filter_var($telefono, FILTER_SANITIZE_STRING);
   $tipo = $_POST['tipo'];
   $correo = $_POST['correo'];
   $correo = filter_var($correo, FILTER_SANITIZE_STRING);
   $pass = ($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = ($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);
   $select_admin = $conn->prepare("SELECT * FROM `tadmin` WHERE tadmin_dni = ?");
   $select_admin->execute([$dniuser]);
   if ($select_admin->rowCount() > 0) {
      $message[] = 'DNI ya existe!';
   } else {
      if ($pass != $cpass) {
         $message[] = 'contraseñas no coinciden!';
      } else {
         $insert_admin = $conn->prepare("INSERT INTO `tadmin`(tadmin_dni, tadmin_nombre, tadmin_password, tadmin_correo, tadmin_telefono, tadmin_estado, tadmin_tipo) VALUES (?,?,?,?,?,?,?)");
         $insert_admin->execute([$dniuser, $name, $pass, $correo, $telefono, $estado, $tipo]);
         $message[] = 'nuevo administrador agregado corectamente';
         $select_products = $conn->prepare("SELECT * FROM `tadmin` WHERE tadmin_dni = ?");
         $select_products->execute([$admin_id]);
         while ($row = $select_products->fetch(PDO::FETCH_ASSOC)) {
            $insert_control = $conn->prepare("INSERT INTO `tcontrol`(Columnid, Columninspeccion, Columnname, Columntimes,dniUser) VALUES (?,?,?,?,?)");
            $insert_control->execute(['0', 'REGISTRO A UN ' . $tipo . 'CON DNI' . $dniuser . ', DE NOMBRE: ' . $name, $row['tadmin_nombre'], $fechaActual, $row['tadmin_dni'],]);
         }
      }
   }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register admin</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="admin_style.css">
</head>

<body>
   <?php
   if (isset($message)) {
      foreach ($message as $message) {
         echo '
         <div class="message">
            <span>' . $message . '</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }
   ?>
   <?php
   // $select_profile = $conn->prepare("SELECT * FROM `tadmin` WHERE tadmin_dni = ?");
   // $select_profile->execute([$admin_id]);
   // $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
   ?>
   <section class="form-container">
      <style>
         .error-message {
            color: red;
         }
      </style>
      <form id="miFormulario" action="" method="post" onsubmit="return validarFormulario()">
         <h3>REGISTRAR USUARIO</h3>
         <h1 class="nombresUpdate">DNI</h1>
         <input type="text" name="dniuser" placeholder="ingrese su DNI" class="box" required>
         <h1 class="nombresUpdate">NOMBRE</h1>
         <input type="text" name="name" required placeholder="ingrese su nombre" maxlength="30" class="box"
            oninput="this.value = this.value.replace(/\s/g, '')">
         <h1 class="nombresUpdate">ESTADO</h1>
         <select class="box" name="estado" id="validationCustom02">
            <option value="activo">activo</option>
            <option value="inactivo">inactivo</option>
         </select>
         <h1 class="nombresUpdate">CELULAR</h1>
         <input type="number" name="telefono" required maxlength="9" class="box">
         <h1 class="nombresUpdate">TIPO</h1>
         <select class="box" name="tipo" id="validationCustom02">
            <option value="administrador">administrador</option>
            <option value="capturista">capturista</option>
         </select>
         <h1 class="nombresUpdate">CORREO</h1>
         <input type="text" name="correo" required placeholder="ingresa tu correo" maxlength="20" class="box">
         <h1 class="nombresUpdate">CONTRASEÑA</h1>
         <input type="password" name="pass" required placeholder="Ingrese una contraseña" maxlength="20" class="box"
            oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="password" name="cpass" required placeholder="confirma su contraseña" maxlength="20" class="box"
            oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="submit" value="registrar" class="btn" name="submit">
         <a href="../dashboard.php" class="btn"> regresar</a>
      </form>
   </section>
   <script>
      function validarFormulario() {
         var formulario = document.getElementById("miFormulario");
         var dniuser = formulario.elements["dniuser"].value;
         var telefono1 = formulario.elements["telefono"].value;
         var correo = formulario.elements["correo"].value;
         var pass = formulario.elements["pass"].value;

         var mensajeError = "";

         // Validación del DNI (puedes ajustar según tus requisitos)
         if (!(/^\d{8}$/.test(dniuser))) {
            mensajeError += "DNI no válido. ";
         }

         // Validación de los números de teléfono
         if (!(/^\d{9}$/.test(telefono1))) {
            mensajeError += "Número de teléfono no válido. ";
         }
         // Validación del correo electrónico
         if (!(/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(correo))) {
            mensajeError += "Correo electrónico no válido. ";
         }
         // Muestra un mensaje de error si es necesario


         if (!/\d/.test(pass)) {
            mensajeError += "La contraseña debe contener al menos un número. ";
         }

         if (mensajeError !== "") {
            alert(mensajeError);
            return false; // Evita que el formulario se envíe
         }
         // Si todo está bien, puedes realizar otras acciones o enviar el formulario
         return true;
      }
   </script>

   <!-- <script src="../js/admin_script.js"></script> -->
</body>

</html>