<?php
include("../../conneccion/dbUnamba.php");
if (isset($_POST['add_product'])) {

   $convocatoria_titulo = $_POST['convocatoria_titulo'];
   $convocatoria_titulo = filter_var($convocatoria_titulo, FILTER_SANITIZE_STRING);
   $convocatoria_resumen = $_POST['convocatoria_resumen'];
   $convocatoria_resumen = filter_var($convocatoria_resumen, FILTER_SANITIZE_STRING);
   $convocatoria_resumen = $_POST['convocatoria_resumen'];
   $convocatoria_resumen = filter_var($convocatoria_resumen, FILTER_SANITIZE_STRING);
   $convocatoria_fecha = $_POST['convocatoria_fecha'];
   $convocatoria_fecha = filter_var($convocatoria_fecha, FILTER_SANITIZE_STRING);
   $convocatoria_base = $_POST['convocatoria_base'];
   $convocatoria_base = filter_var($convocatoria_base, FILTER_SANITIZE_STRING);
   $convocatoria_enlace = $_POST['convocatoria_enlace'];
   $convocatoria_enlace = filter_var($convocatoria_enlace, FILTER_SANITIZE_STRING);
   $select_products = $conn->prepare("SELECT * FROM `tconvocatoria` WHERE convocatoria_titulo = ?");
   $select_products->execute([$convocatoria_titulo]);
   if ($select_products->rowCount() > 0) {
      $message[] = 'product name already exist!';
   } else {
      $insert_products = $conn->prepare("INSERT INTO `tconvocatoria`(convocatoria_id, convocatoria_titulo, convocatoria_resumen, convocatoria_fecha, convocatoria_base, convocatoria_enlace) VALUES(?,?,?,?,?,?)");
      $insert_products->execute(['0', $convocatoria_titulo, $convocatoria_resumen, $convocatoria_fecha, $convocatoria_base, $convocatoria_enlace]);
   }
}
;

if (isset($_GET['delete'])) {

   $delete_id = $_GET['delete'];
   $delete_product_image = $conn->prepare("SELECT * FROM `tconvocatoria` WHERE convocatoria_id = ?");
   $delete_product_image->execute([$delete_id]);

   $delete_product = $conn->prepare("DELETE FROM `tconvocatoria` WHERE convocatoria_id = ?");
   $delete_product->execute([$delete_id]);

   header('location:dashboard.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../STYLES/admin_style.css">
</head>

<body>
   <?php //include '../components/admin_header.php'; 
   ?>
   <section class="add-products">
      <h1 class="heading">convocatoria</h1>
      <form action="" method="post" enctype="multipart/form-data">
         <div class="flex">
            <div class="inputBox">
               <span>convocatoria_titulo(required)</span>
               <input type="text" class="box" required maxlength="100" placeholder="enter convocatoria_titulo"
                  name="convocatoria_titulo">
            </div>
            <div class="inputBox">
               <span>convocatoria_resumen(required)</span>
               <input type="text" class="box" required maxlength="100" placeholder="enter convocatoria_resumen"
                  name="convocatoria_resumen">
            </div>
            <div class="inputBox">
               <span>convocatoria_fecha(required)</span>
               <input type="text" class="box" required maxlength="100" placeholder="enter convocatoria_fecha"
                  name="convocatoria_fecha">
            </div>
            <div class="inputBox">
               <span>link enlace(required)</span>
               <input type="text" class="box" required maxlength="100" placeholder="enter convocatoria_base"
                  name="convocatoria_base">
            </div>
            <div class="inputBox">
               <span>convocatoria_enlace(required)</span>
               <input type="text" class="box" required maxlength="100" placeholder="enter convocatoria_enlace"
                  name="convocatoria_enlace">
            </div>
         </div>
         <input type="submit" value="add product" class="btn" name="add_product">
      </form>
   </section>
   <section class="show-products">

      <h1 class="heading">products added</h1>

      <div class="box-container">

         <?php
         $select_cons = $conn->prepare("SELECT * FROM `tconvocatoria`");
         $select_cons->execute();
         if ($select_cons->rowCount() > 0) {
            while ($fetch_cons = $select_cons->fetch(PDO::FETCH_ASSOC)) {
               ?>
               <div class="box">
                  <div class="name">
                     <?= $fetch_cons['convocatoria_id']; ?>
                  </div>
                  <br>
                  <br>
                  <div class="name">
                     <?= $fetch_cons['convocatoria_resumen']; ?>
                  </div>
                  <br>
                  <br>
                  <div class="name">
                     <?= $fetch_cons['convocatoria_fecha']; ?>
                  </div>
                  <br>
                  <br>
                  <div class="name">
                     <?= $fetch_cons['convocatoria_base']; ?>
                  </div>
                  <br>
                  <br>
                  <div class="details"><span>
                        <?= $fetch_cons['convocatoria_enlace']; ?>
                     </span></div>
                  <div class="flex-btn">
                     <a href="update_product.php?update=<?= $fetch_cons['convocatoria_id']; ?>" class="option-btn">update</a>
                     <a href="products.php?delete=<?= $fetch_cons['convocatoria_id']; ?>" class="delete-btn"
                        onclick="return confirm('delete this product?');">delete</a>
                  </div>
               </div>
               <?php
            }
         } else {
            echo '<p class="empty">no products added yet!</p>';
         }
         ?>
      </div>
   </section>
   <script src="../js/admin_script.js"></script>
</body>

</html>