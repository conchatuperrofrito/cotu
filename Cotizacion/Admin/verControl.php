<?php
include("../conneccion/dbUnamba.php");

?>

<section class="show-products">
    <div class="box-container">
        <div class="search-container"><i class="ri-search-line" style="    padding: 20px;
    color: #18c8a4;
    font-weight: bold; "></i>
            <input type="text" id="VersearchInput" placeholder="Buscar..." style="    width: 300px;
    padding: 5px;
    color: #40b8f2;
    font-weight: bold;
    box-shadow: 0px 0px 10px 2px rgb(159 229 238 / 59%);
    
    ">
        </div>
        <?php
        $Verselect_cons = $conn->prepare("SELECT * FROM `tcontrol` ORDER BY Columntimes DESC");
        $Verselect_cons->execute();
        if ($Verselect_cons->rowCount() > 0) {
            while ($controlfetch_cons = $Verselect_cons->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <div class="box <?php echo $claseFechaPasada; ?> VercotizaciongEN">
                    <!-- Cotizacion\Admin\filePDFcotizacion\FIXTURE.pdf -->
                    <div class="name">
                        &nbsp;&nbsp;<i class="ri-anticlockwise-line" style="color: #d97979;"></i>&nbsp;&nbsp;DNI
                        :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <?= $controlfetch_cons['dniUser']; ?>
                    </div>
                    <div class="name">
                        &nbsp;&nbsp;<i class="ri-user-3-line" style="color: #d97979;"></i>&nbsp;&nbsp;NOMBRE
                        :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <?= $controlfetch_cons['Columnname']; ?>
                    </div>
                    <div class="name">
                        &nbsp;&nbsp;<i class="ri-sound-module-fill" style="color: #d97979;"></i>&nbsp;&nbsp;ACTIVIDAD
                        :&nbsp;&nbsp;&nbsp;
                        <?= $controlfetch_cons['Columninspeccion']; ?>
                    </div>
                    <div class="name">
                        &nbsp;&nbsp;<i class="ri-calendar-schedule-line" style="color: #d97979;"></i>&nbsp;&nbsp;FECHA
                        :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <?= $controlfetch_cons['Columntimes']; ?>
                    </div>
                </div>
                <?php
            }
        } else {
            echo '<p class="empty">no products added yet!</p>';
        }
        ?>
    </div>
    <script>
        document.getElementById('VersearchInput').addEventListener('input', function () {
            var searchTerm = this.value.trim().toLowerCase();
            var boxes = document.getElementsByClassName('VercotizaciongEN');
            for (var i = 0; i < boxes.length; i++) {
                var box = boxes[i];
                var text = box.innerText.toLowerCase();
                if (text.includes(searchTerm)) {
                    box.style.display = 'block';
                } else {
                    box.style.display = 'none';
                }
            }
        });
    </script>
</section>
<footer class="cabezeraCotiza  ">
    <h5> Copyright 2024©
    </h5>
    <h5>
        <a href="https://www.unamba.edu.pe/"> Universidad Nacional Micaela Bastidas de Apurímac
        </a>

    </h5>

</footer>