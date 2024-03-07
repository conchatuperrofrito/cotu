<?php
include("../../conneccion/dbUnamba.php");
if (isset($_POST['submit'])) {
    $update_id = $_POST['id'];
    $update_id = filter_var($update_id, FILTER_SANITIZE_STRING);
    $name = $_POST['nombre'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $DNI = $_POST['DNI'];
    $DNI = filter_var($DNI, FILTER_SANITIZE_STRING);
    $ruc = $_POST['ruc'];
    $ruc = filter_var($ruc, FILTER_SANITIZE_STRING);
    $correo = $_POST['correo'];
    $correo = filter_var($correo, FILTER_SANITIZE_STRING);
    $direccion = $_POST['direccion'];
    $direccion = filter_var($direccion, FILTER_SANITIZE_STRING);
    $phone = $_POST['phone'];
    $phone = filter_var($phone, FILTER_SANITIZE_STRING);
    $continuee = "m3m0cstifler0d3";

    function encrypt($string, $ik)
    {
        $result = '';
        for ($i = 0; $i < strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $ikchar = substr($ik, ($i % strlen($ik)) - 1, 1);
            $char = chr(ord($char) + ord($ikchar));
            $result .= $char;
        }
        return base64_encode($result);
    }
    $tmp_name = $_FILES["pdfFile"]["tmp_name"];
    $namepdf = basename($_FILES["pdfFile"]["name"]);
    $resultadoEncripARCHIVO = encrypt($namepdf, $continuee);
    $numero_aleatorio = rand(100000000, 999999999);
    move_uploaded_file($tmp_name, "filePDFcotizacion/" . $resultadoEncripARCHIVO . $numero_aleatorio);
    $continue = "m3m0c0d3";

    function encryptt($string, $ik)
    {
        $result = '';
        for ($i = 0; $i < strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $ikchar = substr($ik, ($i % strlen($ik)) - 1, 1);
            $char = chr(ord($char) + ord($ikchar));
            $result .= $char;
        }
        return base64_encode($result);
    }
    ///munberencript
    $claveSecreta = 'estaEsUnaClaveSecreta';
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    ///number encript

    $name = encryptt($name, $continue);
    $DNIcrp = encryptt($DNI, $continue);
    $ruccrp = encryptt($ruc, $continue);
    $correo = encryptt($correo, $continue);
    $direccion = encryptt($direccion, $continue);
    $phone = encryptt($phone, $continue);


    $select_products = $conn->query("SELECT Columntsuvirpdf_dni FROM `tsuvirpdf`");
    // $select_products->execute([$DNIcrp]);

    function decrypt($string, $ik)
    {
        $result = '';
        $string = base64_decode($string);
        for ($i = 0; $i < strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $ikchar = substr($ik, ($i % strlen($ik)) - 1, 1);
            $char = chr(ord($char) - ord($ikchar));
            $result .= $char;
        }
        return $result;
    }

    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>

    <body>
        <?php
        if ($select_products->rowCount() == 0) {
            $insert_products = $conn->prepare("INSERT INTO `tsuvirpdf`(tsuvirpdf_codigoConbocatoria, Columntsuvirpdf_nombre, Columntsuvirpdf_dni, Columntsuvirpdf_ruc,tsuvirpdf_correo, Columntsuvirpdf_direccion, Columntsuvirpdf_telefono, Columntsuvirpdf_direccionPDF) VALUES(?,?,?,?,?,?,?,?)");
            $insert_products->execute([$update_id, $name, $DNIcrp, $ruccrp, $correo, $direccion, $phone, $resultadoEncripARCHIVO]);

            if ($insert_products) {
                $message[] = 'nueva propuesta enviada!';
                ?>
                <?php
                header('location:../../index.php');
            }
        } else {
            $bollean = '';
            while ($row = $select_products->fetch(PDO::FETCH_ASSOC)) {
                // Desencriptar el dato obtenido de la base de datos
                $dato_desencriptado = decrypt($row['Columntsuvirpdf_dni'], $continue);
                // Comparar el dato desencriptado con el dato proporcionado por el usuario
                if ($dato_desencriptado == $DNI) {
                    // Aquí puedes realizar las acciones adicionales necesarias
                    $bollean = 'existe';
                    ?>
                    <script>
                        window.onload = function () {
                            // Mostrar un cuadro de diálogo con un mensaje y un botón de aceptar
                            if (confirm('USUARIO YA ESTA POSTULANDO A ESTA COTIZACIÓN')) {
                                // Si el usuario presiona "Aceptar", enviar el formulario automáticamente
                                document.getElementById('form').submit();
                            }
                        }
                    </script>
                    <?php
                    // $message[] = '¡DNI ya  EXISTE';
                    // header('location:formCotizacion.php?id=' . $update_id);
    
                }
            }
            if ($bollean !== 'existe') {
                $insert_products = $conn->prepare("INSERT INTO `tsuvirpdf`(tsuvirpdf_codigoConbocatoria, Columntsuvirpdf_nombre, Columntsuvirpdf_dni, Columntsuvirpdf_ruc,tsuvirpdf_correo, Columntsuvirpdf_direccion, Columntsuvirpdf_telefono, Columntsuvirpdf_direccionPDF) VALUES(?,?,?,?,?,?,?,?)");
                $insert_products->execute([$update_id, $name, $DNIcrp, $ruccrp, $correo, $direccion, $phone, $resultadoEncripARCHIVO]);

                if ($insert_products) {
                    ?>
                    <script>


                        window.onload = function () {
                            // Mostrar un cuadro de diálogo con un mensaje y un botón de aceptar
                            if (confirm('POSTULACIÓN EXITOZA')) {
                                // Si el usuario presiona "Aceptar", enviar el formulario automáticamente
                                document.getElementById('formE').submit();
                            }
                        }

                    </script>

                    <?php
                }
            }




        }


} else {
    echo 'no se envio nada';
}
?>


    <form id="form" method="post">
        <!-- Aquí puedes agregar cualquier otro contenido que desees mostrar -->
        <input type="hidden" name="aceptar">
    </form>

    <?php
    // Verificar si se ha presionado el botón de aceptar
    if (isset($_POST['aceptar'])) {
        // Redirigir a la página deseada
        header('Location: formCotizacion.php?id=' . $update_id);
        exit; // Asegúrate de detener la ejecución del script después de la redirección
    }

    ///////////////FOMR IVIADO/////////////
    ?>

    <form id="formE" method="post">
        <!-- Aquí puedes agregar cualquier otro contenido que desees mostrar -->
        <input type="hidden" name="ga">
    </form>

    <?php
    // Verificar si se ha presionado el botón de aceptar
    if (isset($_POST['ga'])) {
        // Redirigir a la página deseada
        header('location:../../index.php');
        exit; // Asegúrate de detener la ejecución del script después de la redirección
    }


    ?>
</body>

</html>