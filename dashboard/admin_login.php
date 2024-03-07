<?php
include("../conneccion/dbUnamba.php");
session_start();

if (isset($_POST['submit'])) {

   $dniC = $_POST['name'];
   $dni = filter_var($dniC, FILTER_SANITIZE_STRING);
   // echo $dni;
   // $pass = sha1($_POST['pass']);
   $passC = $_POST['pass'];
   $pass = filter_var($passC, FILTER_SANITIZE_STRING);
   // echo $pass;


   $select_admin = $conn->prepare("SELECT * FROM `tadmin` WHERE tadmin_dni = ? AND tadmin_password = ?");
   $select_admin->execute([$dni, $pass]);
   $row = $select_admin->fetch(PDO::FETCH_ASSOC);

   if ($select_admin->rowCount() > 0) {
      // $_SESSION['admin_id'] = $row['id'];
      $_SESSION['dni'] = $row['tadmin_dni'];

      if ($row['tadmin_estado'] == 'inactivo') {
         $message[] = '¡usuario bloqueado.';
      } else if ($row['tadmin_estado'] == 'activo') {
         header('location:dashboard.php');
      } else {
         $message[] = '¡sesión incorecta.';

      }
   } else {
      $message[] = '¡sesión incorecta.';
   }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link href="../Cotizacion/img/faviconUnamba.png" rel="shortcut icon" type="image/vnd.microsoft.icon" />
   <title>LOGINT</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="styles/style.css">
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
   <style>
      /* {logint} */
      .pantalla {
         /* justify-content: center; */
         max-width: 1200px;
         /* background: #74c35a; */
         min-height: 150px;
         padding: 0;
         margin: 0 auto;
         display: -webkit-flex;
         display: flex;
         flex-wrap: wrap;
         box-sizing: border-box;
         justify-content: center;
         font-family: 'Arial', sans-serif;
         font-size: 18px;
      }

      .c-form {
         width: 494px;
         padding: 64px 60px 44px 60px;
         display: flex;
         flex-direction: row;
         flex-wrap: wrap;
         box-sizing: border-box;
         justify-content: center;
         border-radius: 3px;
         border: 1px solid grey;
         background-color: #ffffff;
         font-family: 'Tahoma', sans-serif;
         font-size: 18px;
         font-weight: lighter;
         box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
         margin-top: 180px;
      }

      .c-form input[type=text] {
         width: 100%;
         padding: 20px 20px;
         margin-bottom: 22px;
         display: inline-block;
         box-sizing: border-box;
         font-family: 'Tahoma', sans-serif;
         font-size: 18px;
         color: #b9b9b9;
         background-color: #f2f2f2;
         border: none;
         letter-spacing: 1.3px;
      }

      #submit {
         width: 100%;
         border: none;
         cursor: pointer;
         background-color: #00b242;
         color: #ffffff;
         text-transform: uppercase;
         border-radius: 3px;
         padding: 20px;
         margin-bottom: 18px;
         text-align: center;
         align-items: center;
         font-family: 'Arial', sans-serif;
         font-size: 18px;
         font-weight: 100;
         letter-spacing: 1.3px;
      }

      .c-form div {
         text-align: center;
         margin-bottom: 15px;
      }

      .c-form div span {
         color: #b2b2b2;
      }

      .c-form a {
         color: #00b242;
      }

      .btn {
         height: 40px;
         width: 150px;
         color: white;
         background: blue;
         font-weight: bold;
      }

      .c-form h1 {
         background-color: transparent;
         color: blue;

      }

      .btn:hover {
         color: blue;
         background: white;
         font-weight: bold;

      }

      .textologint {
         color: blue;
         font-weight: bold;

      }
   </style>
   <div class="pantalla">
      <section class="form-container">

         <form action="" method="post" class="c-form">
            <h1> REGISTRO </h1>

            <p>sistema de cotizaciones UNAMBA</p>
            <input type="text" name="name" required placeholder="ingresa tu DNI" maxlength="50" class="box"
               oninput="this.value = this.value.replace(/\s/g, '')" style="color: blue;
         ">
            <input type="password" name="pass" required placeholder="ingresa tu contraseña" maxlength="50" class="box"
               oninput="this.value = this.value.replace(/\s/g, '')" style="color: blue;
         ">
            <div>
               <input type="submit" value="ingresar" class="btn" name="submit">
            </div>
         </form>

         <!-- sd -->
      </section>

   </div>

</body>

</html>