<?php
include("../../conneccion/dbUnamba.php");
session_start();
$code_id = $_GET['idCodigo'];

$admin_id = $_SESSION['dni'];
if (!isset($admin_id)) {
    header('location:../../dashboard/admin_login.php');
}
date_default_timezone_set('America/Lima');
$fechaActual = date('Y-m-d H:i:s');

function desver($string, $ik)
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
$estado;
$code_id = $_GET['idCodigo'];
// echo $code_id;


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../dashboard/styles/style.css" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css" rel="stylesheet" />
    <title>POSTULANTES</title>
</head>

<body>
    <style>
        .box {
            background-color: #f9f9f9;
            border: 1px solid #ccc;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
            width: 500px;
        }

        .box a {
            display: block;
            margin-bottom: 10px;
            text-decoration: none;
            color: #333;
        }

        .info {
            display: flex;
            flex-direction: column;
        }

        .detail {
            display: flex;
            margin-bottom: 10px;
        }

        .label {
            width: 100px;
            font-weight: bold;
        }

        .value {
            flex: 1;

        }

        #contenedor {
            /* width: 200px;
            height: 200px; */
            margin-left: 5%;
            /* background-color: lightblue; */
            /* text-align: center; */
            /* line-height: 200px; */
        }
    </style>
    <section class="show-products">
        <div class="box-container">
            <?php

            $contador = $conn->query("SELECT COUNT(*) AS total FROM tsuvirpdf WHERE tsuvirpdf_codigoConbocatoria = $code_id");
            $total = $contador->fetchColumn();
            ?>
            <h3 class="" style="margin: 15px;
padding: 30px;    margin-bottom:0px ;     padding-bottom: 0px;"> FECHA Y HORA DE REPORTE :
                <?= $fechaActual; ?>'
            </h3>
            <h2 class="" style="margin: 15px;
padding: 30px;  margin-bottom:0px ;     padding-bottom: 0px;">nº cotización :
                <?= $code_id; ?>'
            </h2>
            <h4 class="" style="margin: 15px;
padding: 30px;">TOTAL DE POSTULANTES :
                <?= $total; ?>
            </h4>

            <!-- <h3 style="   text-align: center;
    margin-left: 50%;"> TOTAL DE POSTULANTES:
         
            </h3> -->
            <?php
            //////////
            $select_cons = $conn->prepare("SELECT * FROM `tsuvirpdf` WHERE tsuvirpdf_codigoConbocatoria='$code_id'");
            $select_cons->execute();
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
            if ($select_cons->rowCount() > 0) {
                while ($fetch_cons = $select_cons->fetch(PDO::FETCH_ASSOC)) {
                    $continue = "m3m0c0d3";
                    $continuee = "m3m0cstifler0d3";
                    $name = desver($fetch_cons['Columntsuvirpdf_nombre'], $continue);
                    $DNI = desver($fetch_cons['Columntsuvirpdf_dni'], $continue);
                    $ruc = desver($fetch_cons['Columntsuvirpdf_ruc'], $continue);
                    $correo = desver($fetch_cons['tsuvirpdf_correo'], $continue);
                    $direccion = desver($fetch_cons['Columntsuvirpdf_direccion'], $continue);
                    $phone = desver($fetch_cons['Columntsuvirpdf_telefono'], $continue);
                    $select_profile = $conn->prepare("SELECT * FROM `cotizacion` WHERE nroCotizacion = ?");
                    $select_profile->execute([$fetch_cons['tsuvirpdf_codigoConbocatoria']]);
                    $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
                    $claseFechaPasada = (strtotime($fetch_profile['fechaEntrega']) < strtotime(date('Y-m-d'))) ? 'fecha-pasada' : 'fecha-vigente';
                    $resultado = decrypt($fetch_cons['Columntsuvirpdf_direccionPDF'], $continuee);
                    ?>
                    <div class="box <?php echo $claseFechaPasada; ?>" id="contenedor">
                        <!-- Cotizacion\Admin\filePDFcotizacion\FIXTURE.pdf -->
                        <a href="../Admin/filePDFcotizacion/<?= $fetch_cons['Columntsuvirpdf_direccionPDF']; ?>" download>
                            tiene archivo PDF
                        </a>
                        <div class="info">
                            <div class="detail">
                                <span class="label">Código:</span>
                                <span class="value">
                                    <?= $fetch_cons['tsuvirpdf_codigoConbocatoria']; ?>
                                </span>
                            </div>
                            <div class="detail">
                                <span class="label">Nombre:</span>
                                <span class="value">
                                    <?= $name; ?>
                                </span>
                            </div>
                            <div class="detail">
                                <span class="label">DNI:</span>
                                <span class="value">
                                    <?= $DNI; ?>
                                </span>
                            </div>
                            <div class="detail">
                                <span class="label">RUC:</span>
                                <span class="value">
                                    <?= $ruc; ?>
                                </span>
                            </div>
                            <div class="detail">
                                <span class="label">Correo:</span>
                                <span class="value">
                                    <?= $correo; ?>
                                </span>
                            </div>
                            <div class="detail">
                                <span class="label">Ubicación:</span>
                                <span class="value">
                                    <?= $direccion; ?>
                                </span>
                            </div>
                            <div class="detail">
                                <span class="label">Teléfono:</span>
                                <span class="value">
                                    <?= $phone; ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <?php
                    $Verselect_products = $conn->prepare("SELECT * FROM `tadmin` WHERE tadmin_dni = ?");
                    $Verselect_products->execute([$admin_id]);
                    while ($Verrow = $Verselect_products->fetch(PDO::FETCH_ASSOC)) {
                        $Verinsert_control = $conn->prepare("INSERT INTO `tcontrol`(Columnid, Columninspeccion, Columnname, Columntimes,dniUser) VALUES (?,?,?,?,?)");
                        $Verinsert_control->execute(['0', 'SE HIZO UNA REVICION DE LOS EXPEDIENTES DEL CONCURSO   :' . $fetch_cons['tsuvirpdf_codigoConbocatoria'], $Verrow['tadmin_nombre'], $fechaActual, $Verrow['tadmin_dni'],]);
                    }
                    ?>
                    <?php
                }
            } else {
                $estado = "propuestas";
                echo '<p class="empty"  style="margin: 15px;
                padding: 30px;">no hay' . $estado . ' agregados !</p>';
            }
            ?>
            <style>
                .propuestas {
                    display: none;
                }
            </style>
            <div class="flex-btn <?= $estado ?>">
                <!-- C:\Program Files\xampp\htdocs\cotizacionU\dashboard\dashboard.php -->

                <a href="../../dashboard/dashboard.php?deletee=<?= $fetch_cons['tsuvirpdf_codigoConbocatoria']; ?>"
                    onclick="return confirm('¡ estas seguro de terminar el concurso, losdatos se eliminaran !');" style="margin: 15px;
                padding: 30px;">revisado</a>




            </div>
            <script>
                function imprimir() {
                    window.print();
                }
            </script>
            <button onclick="imprimir()" style="margin: 15px; width: 500px;
                padding: 30px; background-color:white; border: 0px;">FIRMA</button>
        </div>
    </section>



</body>
<script>
    // let fechaTexto
    // let fechaPasada = document.querySelectorAll(".fecha-vigente")
    let boton = document.querySelectorAll(".fecha-vigente")
    boton.forEach(function (elemento) {
        elemento.style.display = 'none';
    });

</script>

</html>