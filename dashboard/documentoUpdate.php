<?php
include("../../conneccion/dbUnamba.php");
if (isset($_POST['update_documento'])) {

    $pid = $_POST['pid'];
    $documento_titulo = $_POST['documento_titulo'];
    $documento_titulo = filter_var($documento_titulo, FILTER_SANITIZE_STRING);

    $documento_resumen = $_POST['documento_resumen'];
    $documento_resumen = filter_var($documento_resumen, FILTER_SANITIZE_STRING);

    $documento_fecha = $_POST['documento_fecha'];
    $documento_fecha = filter_var($documento_fecha, FILTER_SANITIZE_STRING);

    $documento_base = $_POST['documento_base'];
    $documento_base = filter_var($documento_base, FILTER_SANITIZE_STRING);

    $documento_enlace = $_POST['documento_enlace'];
    $documento_enlace = filter_var($documento_enlace, FILTER_SANITIZE_STRING);


    $update_product = $conn->prepare("UPDATE `tdocumento` SET documento_titulo = ?, documento_resumen = ?, documento_fecha = ? , documento_base = ?, documento_enlace = ?WHERE documento_id = ?");
    $update_product->execute([$documento_titulo, $documento_resumen, $documento_fecha, $documento_base, $documento_enlace, $pid]);
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

    <?php // include '../components/admin_header.php'; 
    ?>

    <section class="update-product">

        <h1 class="heading">update product</h1>

        <?php
        $update_id = $_GET['update_documento'];
        $select_products = $conn->prepare("SELECT * FROM `tdocumento` WHERE documento_id = ?");
        $select_products->execute([$update_id]);
        if ($select_products->rowCount() > 0) {
            while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <form action="" method="post" enctype="multipart/form-data">

                    <input type="hidden" name="pid" value="<?= $fetch_products['documento_id']; ?>">

                    <span>update titulo</span>
                    <input type="text" name="documento_titulo" required class="box" maxlength="100"
                        placeholder="enter documento_titulo" value="<?= $fetch_products['documento_titulo']; ?>">

                    <span>update resumen</span>
                    <input type="text" name="documento_resumen" required class="box" maxlength="100"
                        placeholder="enter documento_resumen" value="<?= $fetch_products['documento_resumen']; ?>">


                    <span>update fecha</span>
                    <input type="text" name="documento_fecha" required class="box" maxlength="100"
                        placeholder="enter documento_fecha" value="<?= $fetch_products['documento_fecha']; ?>">


                    <span>update link</span>
                    <input type="text" name="documento_base" required class="box" maxlength="100" placeholder="enter link"
                        value="<?= $fetch_products['documento_base']; ?>">


                    <span>update enlace</span>
                    <input type="text" name="documento_enlace" required class="box" maxlength="100"
                        placeholder="enter documento_enlace" value="<?= $fetch_products['documento_enlace']; ?>">


                    <div class="flex-btn">
                        <input type="submit" name="update_documento" class="btn" value="update_documento">
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