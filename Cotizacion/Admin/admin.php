<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>COTIZACIÓN</title>
  <link rel="stylesheet" href="../css/admin.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body>
  <div class="hed">
    <h2>PANEL ADMIN COTIZACIÓN </h2>
    <style>
      h1 {
        color: white;
        padding: 10px;
      }
    </style>
    <style>
      /* Estilo inicial para ocultar el input */
      #subirmas {
        display: none;
      }

      #subirmasdos {
        display: none;
      }

      #botonmasdos {
        display: none;
        box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.3);
      }

      #botonmas {
        box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.3);
      }

      #botonmasdos:hover,
      #botonmas:hover {
        box-shadow: none;
      }
    </style>
  </div>

  <div class="insertData container">
    <div class="button-return">
      <a href="../index.php" class="btn btn-info registro"
        style="  border-radius: 0px; color:white;  margin-right: 30px;   background-color: #0c1926;" target="_blank"><i
          class="bi bi-table"></i> VER
        REGISTROS</a>
      <a href="../index.php" class="btn btn-info panel"
        style="  color:white; background-color: #0c1926;  border-radius: 0px;  margin-right: 30px;" target="_blank"><i
          class="bi bi-backspace-fill"></i> PANEL
        PRINCIPAL</a>
    </div>
    <form action="../Cotizacion/conection/guardar.php" class="row g-3 needs-validation" method="post"
      enctype="multipart/form-data">
      <div class="col-md-4">
        <label for="validationCustom01" class="form-label">Ingrese Nro. Código Cotización</label>
        <input type="number" class="form-control" name="nroCotizacion" placeholder="&#xf162; 00001" required>
      </div>
      <!-- oninput="this.value = this.value.replace(/\s/g, '')" BALIDACION ENTIENPO REAL  -->
      <div class="col-md-8">
        <label for="validationCustom01" class="form-label">Ingrese la Descripción</label>
        <textarea class="form-control" name="descripcion" placeholder="&#xf1d8; description(max 400-caracteres)..."
          required rows="2" maxlength="400"></textarea>
        <span id="mensajeError"></span>
      </div>

      <div class="col-md-4">
        <label for="validationCustom02" class="form-label">Tipo</label>
        <select class="form-select estado" name="tipo" id="validationCustom02">
          <option value="bienes">bienes</option>
          <option value="servicios">Servicios </option>
        </select>
      </div>
      <div class="col-md-4">
        <label for="validationCustom03" class="form-label">Ingrese la fecha límite de entrega</label>
        <input type="date" class="form-control" id="validationCustom03" name="fechaEntrega" required>
      </div>
      <div class="col-md-4">
        <label for="validationCustom03" class="form-label">Ingrese la fecha Y hora de publicación</label>
        <div style="display:flex;">
          <input type="date" class="form-control" id="validationCustom03" name="fechaSuvida" required>
          <input type="time" class="form-control" id="hora" name="horaSuvida">
        </div>
      </div>
      <div class="col-md-4">
        <label for="validationCustom04" class="form-label">Ingrese la Dependencia</label>
        <!-- <input type="text" class="form-control" id="validationCustom02" name="dependencia" placeholder="Municipalidad de Tamburco" required> -->
        <select class="form-select dependencia" name="dependencia" id="validationCustom04">
          <option selected value="Unamba-Imagen">Unamba-Imagen</option>
          <option selected value="Unamba-RRH">Unamba-RRH</option>
          <option selected value="Unamba-PTT">Unamba-PTT</option>
          <option selected value="Unamba-Imagen">Unamba-Imagen</option>
          <option selected value="Unamba-Tesorería">Unamba-Tesorería</option>
          <option selected value="Unamba-Planificación">Unamba-Planificación </option>
          <option selected value="Unamba-Proyeccion">Unamba-Proyeccion</option>
          <option selected value="Unamba-Calidad">Unamba-Calidad</option>
          <option selected value="Unamba-Desarrollo">Unamba-Desarrollo</option>
          <option selected value="Unamba-Investigación">Unamba-Investigación</option>
          <option selected value="Unamba-Comunicaciones">Unamba-Comunicaciones</option>
          <option selected value="Unamba-Producción">Unamba-Producción</option>
          <option selected value="Unamba-Abastecimiento">Unamba-Abastecimiento</option>
        </select>
      </div>
      <div class="col-md-4">
        <label for="validationCustom02" class="form-label">Subir convocatoria</label>
        <input type="file" class="form-control" id="validationCustom02" name="pdfFile" accept=".pdf" required>

      </div>
      <div class="col-md-4">
        <label for="validationCustom02" class="form-label">ANEXO 1 (-50MB)-opcional</label>
        <input type="file" class="form-control" id="validationCustom02" name="pdfFiledos" accept=".pdf">

      </div>
      <div class="col-md-4" id="botonmas" onclick="mostrarInput()">
        <span>suibir más archivos (opcional)</span>
        <img src="imageDashboard/mas.png" alt="" width="50px" height="50px">
      </div>
      <div class="col-md-4" id="subirmas">
        <label for="validationCustom02" class="form-label">ANEXO 2 (-50MB)-opcional</label>
        <input type="file" class="form-control" id="validationCustom02" name="pdfFileThree" accept=".pdf">

      </div>
      <div class="col-md-4" id="botonmasdos" onclick="mostrarInputdos()">
        <span>suibir un archivo más (opcional)</span>
        <img src="imageDashboard/mas.png" alt="" width="50px" height="50px">
      </div>
      <div class="col-md-4" id="subirmasdos">
        <label for="validationCustom02" class="form-label">ANEXO 3 (-50MB)-opcional</label>
        <input type="file" class="form-control" id="validationCustom02" name="pdfFilefour" accept=".pdf">

      </div>
      <script>
        // Función para mostrar el input
        function mostrarInput() {
          // Obtener el elemento input por su id
          var input = document.getElementById('subirmas');
          var inputicono = document.getElementById('botonmas');
          var inputiconodos = document.getElementById('botonmasdos');
          // Mostrar el input cambiando su estilo
          input.style.display = 'block';
          inputicono.style.display = 'none'
          inputiconodos.style.display = 'block';
        }
        function mostrarInputdos() {
          // Obtener el elemento input por su id
          var inputdos = document.getElementById('subirmasdos');
          var inputiconodos = document.getElementById('botonmasdos');
          // Mostrar el input cambiando su estilo
          inputdos.style.display = 'block';
          inputiconodos.style.display = 'none'
        }
      </script>
      <div class="buttons col-12">
        <input type="submit" style="   background-color: #0c1926; color:white" value="AÑADIR COTIZACIÓN"
          class="btn btn-info" name="add_cot">
      </div>
    </form>
  </div>
  <div>
    <h2>LISTA DE COTIZACIONES </h2>

    <div class="search-container"><i class="ri-search-line" style="    padding: 20px;
    color: #18c8a4;
    font-weight: bold; "></i>
      <input type="text" id="searchInput" placeholder="Buscar..." style="    width: 300px;
    padding: 5px;
    color: #40b8f2;
    font-weight: bold;
    box-shadow: 0px 0px 10px 2px rgb(159 229 238 / 59%);
    ">
    </div>
    <!-- serch  -->
    <section class="show-products">
      <div class="box-container">
        <?php
        $select_cons = $conn->prepare("SELECT * FROM `cotizacion`");
        $select_cons->execute();
        if ($select_cons->rowCount() > 0) {
          while ($fetch_cons = $select_cons->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <div class="box cotizaciongEN">
              <div class="name">
                &nbsp;&nbsp;<i class="ri-code-line" style="color: #d97979;"></i>&nbsp;&nbsp;CODIGO :
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <?= $fetch_cons['nroCotizacion']; ?>
              </div>
              <div class="name">
                &nbsp;&nbsp;<i class="ri-calendar-schedule-line" style="color: #d97979;"></i>&nbsp;&nbsp;FECHA PLAZO :
                &nbsp;&nbsp;&nbsp;&nbsp;
                <?= $fetch_cons['fechaEntrega']; ?>
              </div>
              <div class="name">
                &nbsp;&nbsp;<i class="ri-menu-search-line" style="color: #d97979;"></i>&nbsp;&nbsp;TIPO :
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <?= $fetch_cons['cotizacion_tipo']; ?>
              </div>
              <div class="name">
                &nbsp;&nbsp;<i class="ri-bubble-chart-line" style="color: #d97979;"></i>&nbsp;&nbsp;ESTADO :
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <?= $fetch_cons['estado']; ?>
              </div>
              <div class="name">
                &nbsp;&nbsp;<i class="ri-message-2-line" style="color: #d97979;"></i>&nbsp;&nbsp;DESCRIPCIÓN :
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <?= $fetch_cons['descripcion']; ?>
              </div>
              <div class="name">
                &nbsp;&nbsp;<i class="ri-community-line" style="color: #d97979;"></i>&nbsp;&nbsp;DEPENDENCIA :
                &nbsp;&nbsp;&nbsp;&nbsp;
                <?= $fetch_cons['dependencia']; ?>z
              </div>
              <div class="flex-btn">
                <!-- C:\Program Files\xampp\htdocs\cotizacionU\dashboard\dashboard.php -->
                &nbsp;&nbsp;<a href="../dashboard/dashboard.php?delete=<?= $fetch_cons['nroCotizacion']; ?>"
                  onclick="return confirm('delete this product?');" class="btn btn-info"
                  style="   background-color: #0c1926; color:white">eliminar</a>
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
    <script>
      document.getElementById('searchInput').addEventListener('input', function () {
        var searchTerm = this.value.trim().toLowerCase();
        var boxes = document.getElementsByClassName('cotizaciongEN');
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
  </div>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"
    integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS"
    crossorigin="anonymous"></script>
  <footer class="cabezeraCotiza  ">
    <h5> Copyright 2024©
    </h5>
    <h5>
      <a href="https://www.unamba.edu.pe/"> Universidad Nacional Micaela Bastidas de Apurímac
      </a>
    </h5>
  </footer>
</body>

</html>