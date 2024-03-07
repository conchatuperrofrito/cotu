<?php

include("../../conneccion/dbUnamba.php");
if (isset($_POST['update_ultimaNota_enlace'])) {

    $pid = $_POST['pid'];
    $comunicadoPrensa_titulo = $_POST['ultimaNota_titulo'];
    $comunicadoPrensa_titulo = filter_var($comunicadoPrensa_titulo, FILTER_SANITIZE_STRING);

    $comunicadoPrensa_resumen = $_POST['ultimaNota_resumen'];
    $comunicadoPrensa_resumen = filter_var($comunicadoPrensa_resumen, FILTER_SANITIZE_STRING);

    $comunicadoPrensa_fecha = $_POST['ultimaNota_prensa_fecha'];
    $comunicadoPrensa_fecha = filter_var($comunicadoPrensa_fecha, FILTER_SANITIZE_STRING);

    $comunicadoPrensa_base = $_POST['ultimaNota_prensa_base'];
    $comunicadoPrensa_base = filter_var($comunicadoPrensa_base, FILTER_SANITIZE_STRING);

    $comunicadoPrensa_enlace = $_POST['ultimaNota_enlace'];
    $comunicadoPrensa_enlace = filter_var($comunicadoPrensa_enlace, FILTER_SANITIZE_STRING);


    $update_product = $conn->prepare("UPDATE `tultimanota` SET ultimaNota_titulo = ?, ultimaNota_resumen = ?, ultimaNota_prensa_fecha = ? , ultimaNota_prensa_base = ?, ultimaNota_enlace = ?WHERE ultimaNota_id = ?");
    $update_product->execute([$comunicadoPrensa_titulo, $comunicadoPrensa_resumen, $comunicadoPrensa_fecha, $comunicadoPrensa_base, $comunicadoPrensa_enlace, $pid]);
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
        $update_id = $_GET['update_ultimaNota'];
        $select_products = $conn->prepare("SELECT * FROM `tultimanota` WHERE ultimaNota_id = ?");
        $select_products->execute([$update_id]);
        if ($select_products->rowCount() > 0) {
            while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <form action="" method="post" enctype="multipart/form-data">

                    <input type="hidden" name="pid" value="<?= $fetch_products['ultimaNota_id']; ?>">

                    <span>update titulo</span>
                    <input type="text" name="ultimaNota_titulo" required class="box" maxlength="100"
                        placeholder="enter ultimaNota_titulo" value="<?= $fetch_products['ultimaNota_titulo']; ?>">

                    <span>update resumen</span>
                    <input type="text" name="ultimaNota_resumen" required class="box" maxlength="100"
                        placeholder="enter ultimaNota_resumen" value="<?= $fetch_products['ultimaNota_resumen']; ?>">


                    <span>update fecha</span>
                    <input type="text" name="ultimaNota_prensa_fecha" required class="box" maxlength="100"
                        placeholder="enter ultimaNota_prensa_fecha" value="<?= $fetch_products['ultimaNota_prensa_fecha']; ?>">


                    <span>update link</span>
                    <input type="text" name="ultimaNota_prensa_base" required class="box" maxlength="100"
                        placeholder="enter link" value="<?= $fetch_products['ultimaNota_prensa_base']; ?>">


                    <span>update enlace</span>
                    <input type="text" name="ultimaNota_enlace" required class="box" maxlength="100"
                        placeholder="enter ultimaNota_enlace" value="<?= $fetch_products['ultimaNota_enlace']; ?>">


                    <div class="flex-btn">
                        <input type="submit" name="update_ultimaNota_enlace" class="btn" value="update_ultimaNota_enlace">
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