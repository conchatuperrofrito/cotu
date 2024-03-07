<?php
include("../../conneccion/dbUnamba.php");
if (isset($_POST['add_product_ultimaNota'])) {
    $ultimaNota_titulo = $_POST['ultimaNota_titulo'];
    $ultimaNota_titulo = filter_var($ultimaNota_titulo, FILTER_SANITIZE_STRING);
    $ultimaNota_resumen = $_POST['ultimaNota_resumen'];
    $ultimaNota_resumen = filter_var($ultimaNota_resumen, FILTER_SANITIZE_STRING);
    $ultimaNota_fecha = $_POST['ultimaNota_fecha'];
    $ultimaNota_fecha = filter_var($ultimaNota_fecha, FILTER_SANITIZE_STRING);
    $ultimaNota_base = $_POST['ultimaNota_base'];
    $ultimaNota_base = filter_var($ultimaNota_base, FILTER_SANITIZE_STRING);
    $ultimaNota_enlace = $_POST['ultimaNota_enlace'];
    $ultimaNota_enlace = filter_var($ultimaNota_enlace, FILTER_SANITIZE_STRING);
    $select_products = $conn->prepare("SELECT * FROM `tultimanota` WHERE ultimaNota_titulo = ?");
    $select_products->execute([$ultimaNota_titulo]);
    if ($select_products->rowCount() > 0) {
        $message[] = 'product name already exist!';
    } else {
        $insert_products = $conn->prepare("INSERT INTO `tultimanota`(ultimaNota_id, ultimaNota_titulo, ultimaNota_resumen, ultimaNota_prensa_fecha, ultimaNota_prensa_base, ultimaNota_enlace) VALUES(?,?,?,?,?,?)");
        $insert_products->execute(['0', $ultimaNota_titulo, $ultimaNota_resumen, $ultimaNota_fecha, $ultimaNota_base, $ultimaNota_enlace]);
    }
};
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_product_image = $conn->prepare("SELECT * FROM `tultimaNota` WHERE ultimaNota_id = ?");
    $delete_product_image->execute([$delete_id]);
    $delete_product = $conn->prepare("DELETE FROM `tultimaNota` WHERE ultimaNota_id = ?");
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
    <?php
    ?>
    <section class="add-products">
        <h1 class="heading">ultima Nota</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="flex">
                <div class="inputBox">
                    <span>ultimaNota_titulo(required)</span>
                    <input type="text" class="box" required maxlength="100" placeholder="enter ultimaNota_titulo" name="ultimaNota_titulo">
                </div>
                <div class="inputBox">
                    <span>ultimaNota_resumen(required)</span>
                    <input type="text" class="box" required maxlength="100" placeholder="enter ultimaNota_resumen" name="ultimaNota_resumen">
                </div>

                <div class="inputBox">
                    <span>ultimaNota_fecha(required)</span>
                    <input type="text" class="box" required maxlength="100" placeholder="enter ultimaNota_fecha" name="ultimaNota_fecha">
                </div>

                <div class="inputBox">
                    <span>link enlace(required)</span>
                    <input type="text" class="box" required maxlength="100" placeholder="enter ultimaNota_base" name="ultimaNota_base">
                </div>

                <div class="inputBox">
                    <span>ultimaNota_enlace(required)</span>
                    <input type="text" class="box" required maxlength="100" placeholder="enter ultimaNota_enlace" name="ultimaNota_enlace">
                </div>
            </div>
            <input type="submit" value="add product" class="btn" name="add_product_ultimaNota">
        </form>
    </section>
    <section class="show-products">
        <h1 class="heading">products added</h1>
        <div class="box-container">
            <?php
            $select_cons = $conn->prepare("SELECT * FROM `tultimanota`");
            $select_cons->execute();
            if ($select_cons->rowCount() > 0) {
                while ($fetch_cons = $select_cons->fetch(PDO::FETCH_ASSOC)) {
            ?>
                    <div class="box">
                        <div class="name"><?= $fetch_cons['ultimaNota_id']; ?></div>
                        <br>
                        <br>
                        <div class="name"><?= $fetch_cons['ultimaNota_resumen']; ?></div>
                        <br>
                        <br>
                        <div class="name"><?= $fetch_cons['ultimaNota_prensa_fecha']; ?></div>
                        <br>
                        <br>
                        <div class="name"><?= $fetch_cons['ultimaNota_prensa_base']; ?></div>
                        <br>
                        <br>
                        <div class="details"><span><?= $fetch_cons['ultimaNota_enlace']; ?></span></div>
                        <div class="flex-btn">
                            <a href="ultimanota_update.php?update_ultimaNota=<?= $fetch_cons['ultimaNota_id']; ?>" class="option-btn">update</a>
                            <a href="ultimanota.php?delete=<?= $fetch_cons['ultimaNota_id']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">delete</a>
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