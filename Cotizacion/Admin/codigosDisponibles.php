<?php
include("../conneccion/dbUnamba.php");
// session_start();
$admin_id = $_SESSION['dni'];
if (!isset($admin_id)) {
    header('location:../../dashboard/admin_login.php');
}
?>
<h1>bienes</h1>
<style>
    .aref {
        text-decoration: none;
    }
</style>
<section class="caja">
    <div class="botones_padre">
        <?php
        $select_codigos = $conn->prepare("SELECT * FROM `cotizacion` where cotizacion_tipo='bienes'");
        $select_codigos->execute();
        if ($select_codigos->rowCount() > 0) {
            while ($fetch_consti = $select_codigos->fetch(PDO::FETCH_ASSOC)) {
                $claseFechaPasadaCodigo = (strtotime($fetch_consti['fechaEntrega']) < strtotime(date('Y-m-d'))) ? 'fecha-pasadaCode' : 'fecha-vigenteCode';
                ?>
                <!-- Cotizacion\Admin\filePDFcotizacion\FIXTURE.pdf -->
                <div class="botones <?php echo $claseFechaPasadaCodigo; ?>">
                    <a href="../Cotizacion/Admin/formCotizacionMuestra.php?idCodigo=<?= $fetch_consti['nroCotizacion']; ?>"
                        class="aref">
                        codigo :
                        <?= $fetch_consti['nroCotizacion'] . "\n"; ?>
                        <br>
                        <?= $fetch_consti['cotizacion_tipo'] . "\n"; ?>
                        <br>
                        <?= $fetch_consti['estado'] . "\n"; ?>
                    </a>
                </div>
                <?php
            }
        } else {
            echo '<p class="empty">todavia no cotización bienes!</p>';
        }
        ?>
    </div>
</section>
<h1>servicios</h1>
<section class="caja">
    <div class="botones_padre">
        <?php
        $select_codigos2 = $conn->prepare("SELECT * FROM `cotizacion` where cotizacion_tipo='servicios'");
        $select_codigos2->execute();
        if ($select_codigos2->rowCount() > 0) {
            while ($fetch_consti2 = $select_codigos2->fetch(PDO::FETCH_ASSOC)) {
                $claseFechaPasadaCodigo2 = (strtotime($fetch_consti2['fechaEntrega']) < strtotime(date('Y-m-d'))) ? 'fecha-pasadaCode' : 'fecha-vigenteCode';

                ?>

                <!-- Cotizacion\Admin\filePDFcotizacion\FIXTURE.pdf -->
                <div class="botones <?php echo $claseFechaPasadaCodigo2; ?>">
                    <a href="../Cotizacion/Admin/formCotizacionMuestra.php?idCodigo=<?= $fetch_consti2['nroCotizacion']; ?>"
                        class="aref">
                        codigo :
                        <?= $fetch_consti2['nroCotizacion'] . "\n"; ?>
                        <br>

                        <?= $fetch_consti2['cotizacion_tipo'] . "\n"; ?>
                        <br>

                        <?= $fetch_consti2['estado'] . "\n"; ?>
                    </a>

                </div>

                <?php
            }
        } else {
            echo '<p class="empty">todavia no cotización servicios!</p>';
        }
        ?>

    </div>

</section>

<style>
    .botones {
        flex-direction: column;
    }

    .fecha-vigenteCode a {
        font-family: math;
        font-weight: bold;
        text-align: center;
        color: #ff0000bf;
        background-color: #e7ff25;
        /* width: 150px; */
    }
</style>
<script>

    var listas = document.querySelectorAll('.fecha-vigenteCode');

    // Iterar sobre cada elemento lista
    listas.forEach(function (lista) {
        // Obtener el enlace dentro de la lista
        var enlace = lista.querySelector('a');

        // Obtener la URL actual del enlace
        var urlActual = enlace.getAttribute('href');

        // Reemplazar la parte de la URL que deseas cambiar
        var nuevaURL = urlActual.replace(
            'formCotizacionMuestra.php',
            'reporte.php'
        );
        // Actualizar el atributo href del enlace con la nueva URL
        enlace.setAttribute('href', nuevaURL);
    });

    // var contenedores = document.querySelectorAll('.fecha-vigenteCode');

    // // Iterar sobre cada elemento contenedor
    // contenedores.forEach(function (contenedor) {
    //     // Obtener el enlace dentro del contenedor
    //     var enlace = contenedor.querySelector('a');

    //     // Reemplazar la dirección del enlace
    //     enlace.href = '../Cotizacion/Admin/reporte.php?idCodigo=' +
    // });

</script>
<footer class="cabezeraCotiza  ">
    <h5> Copyright 2024©
    </h5>
    <h5>
        <a href="https://www.unamba.edu.pe/"> Universidad Nacional Micaela Bastidas de Apurímac
        </a>
    </h5>

</footer>