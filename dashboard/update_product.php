<?php
include("../../conneccion/dbUnamba.php");
session_start();
$admin_id = $_SESSION['dni_viajero'];
if (!isset($admin_id)) {
   header('location:admin_login.php');
}
if (isset($_POST['update'])) {
   $pid = $_POST['pid'];
   $convocatoria_titulo = $_POST['convocatoria_titulo'];
   $convocatoria_titulo = filter_var($convocatoria_titulo, FILTER_SANITIZE_STRING);
   $convocatoria_resumen = $_POST['convocatoria_resumen'];
   $convocatoria_resumen = filter_var($convocatoria_resumen, FILTER_SANITIZE_STRING);
   $convocatoria_fecha = $_POST['convocatoria_fecha'];
   $convocatoria_fecha = filter_var($convocatoria_fecha, FILTER_SANITIZE_STRING);
   $convocatoria_base = $_POST['convocatoria_base'];
   $convocatoria_base = filter_var($convocatoria_base, FILTER_SANITIZE_STRING);
   $convocatoria_enlace = $_POST['convocatoria_enlace'];
   $convocatoria_enlace = filter_var($convocatoria_enlace, FILTER_SANITIZE_STRING);
   $update_product = $conn->prepare("UPDATE `tconvocatoria` SET convocatoria_titulo = ?, convocatoria_resumen = ?, convocatoria_fecha = ? , convocatoria_base = ?, convocatoria_enlace = ?WHERE convocatoria_id = ?");
   $update_product->execute([$convocatoria_titulo, $convocatoria_resumen, $convocatoria_fecha, $convocatoria_base, $convocatoria_enlace, $pid]);
   $message[] = 'product updated successfully!';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update product</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../STYLES/admin_style.css">
</head>

<body>
   <?php
   ?>
   <section class="update-product">
      <h1 class="heading">update product</h1>
      <?php
      $update_id = $_GET['update'];
      $select_products = $conn->prepare("SELECT * FROM `tconvocatoria` WHERE convocatoria_id = ?");
      $select_products->execute([$update_id]);
      if ($select_products->rowCount() > 0) {
         while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <form action="" method="post" enctype="multipart/form-data">
               <input type="hidden" name="pid" value="<?= $fetch_products['convocatoria_id']; ?>">
               <span>update titulo</span>
               <input type="text" name="convocatoria_titulo" required class="box" maxlength="100"
                  placeholder="enter convocatoria_titulo" value="<?= $fetch_products['convocatoria_titulo']; ?>">
               <span>update resumen</span>
               <input type="text" name="convocatoria_resumen" required class="box" maxlength="100"
                  placeholder="enter convocatoria_resumen" value="<?= $fetch_products['convocatoria_resumen']; ?>">
               <span>update fecha</span>
               <input type="text" name="convocatoria_fecha" required class="box" maxlength="100"
                  placeholder="enter convocatoria_fecha" value="<?= $fetch_products['convocatoria_fecha']; ?>">
               <span>update link</span>
               <input type="text" name="convocatoria_base" required class="box" maxlength="100" placeholder="enter link"
                  value="<?= $fetch_products['convocatoria_base']; ?>">
               <span>update enlace</span>
               <input type="text" name="convocatoria_enlace" required class="box" maxlength="100"
                  placeholder="enter convocatoria_enlace" value="<?= $fetch_products['convocatoria_enlace']; ?>">
               <div class="flex-btn">
                  <input type="submit" name="update" class="btn" value="update">
                  <a href="dashboard.php" class="option-btn">go back</a>
               </div>
            </form>
            <?php
         }
      } else {
         echo '<p class="empty">no product found!</p>';
      }
      ?>
   </section>
   <script src="../js/admin_script.js"></script>
</body>

</html>