<?php
include("../conneccion/dbUnamba.php");
session_start();
$admin_id = $_SESSION['dni'];
if (!isset($admin_id)) {
  header('location:admin_login.php');
}
$fechaActual = date('Y-m-d H:i:s');

$select_admin = $conn->prepare("SELECT * FROM `tadmin` WHERE tadmin_dni = ? ");
$select_admin->execute([$admin_id]);
$row = $select_admin->fetch(PDO::FETCH_ASSOC);
if ($row['tadmin_estado'] == 'inactivo') {
  header('location:admin_login.php');
}

if (isset($_GET['delete'])) {
  $delete_id = $_GET['delete'];
  $delete_product_image = $conn->prepare("SELECT * FROM `cotizacion` WHERE nroCotizacion= ?");
  $delete_product_image->execute([$delete_id]);
  $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
  unlink('../Cotizacion/conection/carpeta_pdf/' . $fetch_delete_image['pdfCot']);

  $delete_product = $conn->prepare("DELETE FROM `cotizacion` WHERE nroCotizacion= ?");
  $delete_product->execute([$delete_id]);
  // C:\Program Files\xampp\htdocs\cotizacionU\dashboard\dashboard.php
  $CotDeleteselect_products = $conn->prepare("SELECT * FROM `tadmin` WHERE tadmin_dni = ?");
  $CotDeleteselect_products->execute([$admin_id]);
  while ($CotDeleterow = $CotDeleteselect_products->fetch(PDO::FETCH_ASSOC)) {
    $CotDeleteinsert_control = $conn->prepare("INSERT INTO `tcontrol`(Columnid, Columninspeccion, Columnname, Columntimes,dniUser) VALUES (?,?,?,?,?)");
    $CotDeleteinsert_control->execute(['0', 'ELIMINO UNA COTIZACIÓN  NUMERO:' . $delete_id, $CotDeleterow['tadmin_nombre'], $fechaActual, $CotDeleterow['tadmin_dni'],]);
  }
  header('location:../dashboard/dashboard.php');
}
// 
if (isset($_GET['deletee'])) {
  $delete_id2 = $_GET['deletee'];
  $delete_productt = $conn->prepare("SELECT * FROM `tsuvirpdf` WHERE tsuvirpdf_codigoConbocatoria= ?");
  $delete_productt->execute([$delete_id2]);
  $fetch_deletet = $delete_productt->fetch(PDO::FETCH_ASSOC);

  if ($fetch_deletet) {
    // Elimina el archivo
    unlink('../Cotizacion/Admin/filePDFcotizacion/' . $fetch_deletet['tsuvirpdf_direccionPDF']);

    // Elimina el registro de la base de datos
    $delete_query = $conn->prepare("DELETE FROM `tsuvirpdf` WHERE tsuvirpdf_codigoConbocatoria= ?");
    $delete_query->execute([$delete_id2]);

    echo "Registros eliminado exitosamente.";
  } else {
    echo "No se encontró ningún registro con el código especificado.";
  }
  // C:\Program Files\xampp\htdocs\cotizacionU\dashboard\dashboard.php
  $Deleteselect_products = $conn->prepare("SELECT * FROM `tadmin` WHERE tadmin_dni = ?");
  $Deleteselect_products->execute([$admin_id]);
  while ($Deleterow = $Deleteselect_products->fetch(PDO::FETCH_ASSOC)) {
    $Deleteinsert_control = $conn->prepare("INSERT INTO `tcontrol`(Columnid, Columninspeccion, Columnname, Columntimes,dniUser) VALUES (?,?,?,?,?)");
    $Deleteinsert_control->execute(['0', 'ELIMINO LISTA DE POSTULANTES:' . $delete_id2, $Deleterow['tadmin_nombre'], $fechaActual, $Deleterow['tadmin_dni'],]);
  }
  header('location:../dashboard/dashboard.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="../Cotizacion/img/faviconUnamba.png" rel="shortcut icon" type="image/vnd.microsoft.icon" />
  <title>DASHBOARD</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <link rel="stylesheet" href="styles/style.css" />
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css" rel="stylesheet" />
  <script src="script/script.js"></script>

</head>

<body>
  <!-- load  start-->

  <style>
    .capturista {
      display: none;
    }

    .cabezeraCotiza {
      /* margin-top: 10px; */
      margin-left: 150px;
      margin-right: 150px;
      display: flex;
      justify-content: space-between;

    }

    /* Estilos para la imagen de carga */
    #imagen-carga {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      z-index: 9999;
    }
  </style>
  <img id="imagen-carga" src="Loading_2.gif" alt="Cargando...">


  <script>
    // Función para mostrar la imagen de carga
    function mostrarImagenCarga() {
      document.getElementById('imagen-carga').style.display = 'block';
    }

    // Función para ocultar la imagen de carga
    function ocultarImagenCarga() {
      document.getElementById('imagen-carga').style.display = 'none';
    }

    // Evento de carga de la página
    window.addEventListener('load', function () {
      // Ocultar la imagen de carga cuando la página se haya cargado completamente
      ocultarImagenCarga();
    });

    // Evento de descarga de la página (antes de que se recargue)
    window.addEventListener('beforeunload', function () {
      // Mostrar la imagen de carga antes de recargar la página
      mostrarImagenCarga();
    });
  </script>
  <!-- load  fin-->
  <script>


  </script>
  <span class="bckg"></span>
  <header>

    <h1>UNAMBA</h1>

    <nav>
      <ul>
        <li>
          <a href="javascript:void(0);">Cotizaciones</a>
        </li>

        <li class="<?= $row['tadmin_tipo'] ?>">
          <a href="javascript:void(0);">Solicitudes</a>
        </li>

        <li class="<?= $row['tadmin_tipo'] ?>">
          <a href=" javascript:void(0);">Control</a>
        </li>

        <li>
          <a href="javascript:void(0);">Usuarios</a>
        </li>
        <li>
          <a href="javascript:void(0);">Contacto</a>
        </li>
        <li>
          <a href="javascript:void(0);">Ver Contacto</a>
        </li>
      </ul>
    </nav>
  </header>
  <main>
    <div class="title">
      <h2 id="fechaHoraActualizacion"> Actualización:
        <i class="ri-calendar-schedule-fill" style="color: #18c8a4; "></i>
      </h2>
      <script>
        // Obtener la fecha y hora actual
        var fechaHoraActual = new Date();
        // Obtener los componentes de la fecha
        var dia = fechaHoraActual.getDate();
        var mes = fechaHoraActual.getMonth() + 1; // Sumar 1 porque los meses comienzan desde 0
        var año = fechaHoraActual.getFullYear();
        // Obtener los componentes de la hora
        var horas = fechaHoraActual.getHours();
        var minutos = fechaHoraActual.getMinutes();
        var segundos = fechaHoraActual.getSeconds();
        // Formatear la fecha como dd/mm/yyyy
        var fechaFormateada = dia + '/' + mes + '/' + año;
        // Formatear la hora como hh:mm:ss
        var horaFormateada = horas + ':' + minutos + ':' + segundos;
        // Mostrar la fecha y hora en el elemento HTML
        document.getElementById('fechaHoraActualizacion').textContent += fechaFormateada + ' ' + horaFormateada;
      </script>
      <?php
      $select_profile = $conn->prepare("SELECT * FROM `tadmin` WHERE tadmin_dni = ?");
      $select_profile->execute([$admin_id]);
      $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
      ?>
      <a id="user-btn" style="
    font-size: x-large;
"><i class="ri-user-2-fill" style="color: #18c8a4; "></i> HOLA ING :
        <?= $fetch_profile['tadmin_nombre']; ?> !
      </a>
      <style>
        .profile {
          box-shadow: -5px 6px 8px 5px rgba(0, 0, 0, 0.3);

          position: absolute;
          right: 2rem;
          background-color: white;
          border-radius: .5rem;
          text-align: center;
          padding-top: 1.2rem;
          display: none;
          animation: fadeIn .2s linear;
          font-family: 'JetBrains Mono', monospace;
        }

        .profile a {
          padding: 5px;
          font-family: system-ui;
          font-size: 20px;
          background-color: white;
        }

        .profile a:hover {

          background-color: rgba(0, 0, 0, 0.3);
        }

        .profile.active {
          display: inline-block;
        }

        .profile p {
          padding: 0px 15px;
          text-align: center;
          color: black;
          font-size: 1.5rem;
          margin-bottom: 1rem;
        }

        .option-btn {
          text-decoration: none;
          background-color: rgba(84, 115, 151, 0.115);
        }

        .flex-btn {
          /* outline: 1px solid black; */
        }
      </style>
    </div>
    <div class="profile">
      <?php
      // $select_profile = $conn->prepare("SELECT * FROM `ejemplo` WHERE id = ?");
      // $select_profile->execute([$admin_id]);
      // $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
      ?>
      <p id="roltipo">
        <i class="ri-user-settings-line" style="color: #18c8a4; "></i>

        <?= $fetch_profile['tadmin_tipo']; ?>
      </p>
      <p id="rolestado"><i class="ri-bubble-chart-line" style="color: #18c8a4; "></i>
        <?= $fetch_profile['tadmin_estado']; ?>
      </p>
      <a href="profile/update_profile.php" class="option-btn"><i class="ri-folder-user-line"
          style="color: #18c8a4; "></i> actualizar perfil</a>
      <div id="admin" class="flex-btn <?= $row['tadmin_tipo'] ?>">
        <a href="profile/register_admin.php" class="option-btn "> <i class="ri-arrow-go-forward-line"
            style="color: #18c8a4; "></i>registrar</a>
        <!-- <a href="admin_login.php" class="option-btn ">soy usuario</a> -->
      </div>
      <a href="profile/admin_logout.php" class="delete-btn"
        onclick="return confirm('¿cerrar sesión en el sitio web?');"><i class="ri-login-box-line"
          style="color: #18c8a4; "></i> cerrar
        sesión
      </a>
    </div>
    <script>
      let profile = document.querySelector('.profile');
      document.querySelector('#user-btn').onclick = () => {
        profile.classList.toggle('active');
        navbar.classList.remove('active');
      }
      window.onscroll = () => {
        navbar.classList.remove('active');
        profile.classList.remove('active');
      }
      let mainImage = document.querySelector('.update-product .image-container .main-image img');
      let subImages = document.querySelectorAll('.update-product .image-container .sub-image img');
      subImages.forEach(images => {
        images.onclick = () => {
          src = images.getAttribute('src');
          mainImage.src = src;
        }
      });
    </script>
    <!-- ARTICULO 7 -->
    <article class="larg">
      <div>
        <h3><i class="ri-chat-settings-fill" style="    color: #18c8a4;"></i> Tome un momento para
          familiarizarse con las recomendaciones. <i class="ri-skip-down-line" style="    color: red;"></i></h3>
        <p>
          <i class="ri-asterisk" style="    color: #18c8a4;"></i> Asegúrate completar la cotización, sean claras y
          fáciles de entender.
        </p>
        <p>
          <i class="ri-asterisk" style="    color: #18c8a4;"></i> Está protegido contra alteraciones de scripts
          maliciosos, garantizando así la seguridad de sus datos.
        </p>
        <p>
          <i class="ri-asterisk" style="    color: #18c8a4;"></i> Está supervisado por un control de actividades.
        </p>
        <p>
          <i class="ri-asterisk" style="    color: #18c8a4;"></i> Comunicate con soporte en caso de que tengan preguntas
          o necesiten ayuda para completar la cotización.
        </p>
      </div>

      <?php include '../Cotizacion/Admin/admin.php'; ?>
    </article>
    <!-- ARTICULO 7 -->
    <article class="larg <?= $row['tadmin_tipo'] ?>">
      <div>
        <h3><i class="ri-chat-settings-fill" style="    color: #18c8a4;"></i> Tome un momento para
          familiarizarse con las recomendaciones. <i class="ri-skip-down-line" style="    color: red;"></i></h3>
        <p>
          <i class="ri-asterisk" style="    color: #18c8a4;"></i> Las cotizaciones no finalizadas el proceso de
          postulación no aparecerán.
        </p>
        <p>
          <i class="ri-asterisk" style="    color: #18c8a4;"></i> Una vez ingresado se estará realizando fase de
          concurso, evaluación de expedientes.
        </p>
        <p>
          <i class="ri-asterisk" style="    color: #18c8a4;"></i> Solo puede eliminar una sola vez, limpie las
          solicitudes solo cuando finalice la revisión.
        </p>
      </div>
      <?php
      include '../Cotizacion/Admin/codigosDisponibles.php';
      ?>
    </article>
    <!-- ARTICULO 7 -->
    <article class="larg">
      <div>
        <h3><i class="ri-chat-settings-fill" style="    color: #18c8a4;"></i> Tome un momento para
          familiarizarse con las recomendaciones. <i class="ri-skip-down-line" style="    color: red;"></i></h3>
        <p>
          <i class="ri-asterisk" style="    color: #18c8a4;"></i> Los registros se eliminaran periodicamente
          automatiamente.
        </p>
      </div>

      <?php
      include '../Cotizacion/Admin/verControl.php';

      ?>
    </article>
    <!-- ARTICULO 7 -->
    <article class="larg">
      <div>
        <h3>mensaje Usu<span class="entypo-down-open"></span></h3>
        <p>
          Lorem ipsum dolor sit amet, consectetur adipisicing elit. Temporibus
          iste quia incidunt ad provident ullam quo assumenda expedita quae
          sapiente ipsa qui esse similique! Modi obcaecati natus sapiente
          quaerat omnis.
        </p>
      </div>
      <!-- traba inicio   -->
      <div class="tabla">


        <main>
          <style>
            /* Estilo para pantallas más grandes que 1200px */
            @import url('https://fonts.googleapis.com/css2?family=Changa:wght@200..800&family=Saira+Condensed:wght@200&display=swap');

            @media (min-width: 1200px) {
              .container {
                max-width: 1400px;
              }
            }

            .og-contianer {
              font-family: "Changa", sans-serif;
              font-optical-sizing: auto;
            }

            .registropagina {
              display: flex;
              justify-content: flex-start;
            }

            .cabezerafilter {
              display: flex;
              justify-content: flex-end;
            }

            .custom-select {
              width: 200px;
              /* Ancho personalizado */
              padding: 8px;
              border: 1px solid #ccc;
              border-radius: 4px;
              font-size: 16px;
            }

            /* Estilo para las opciones */
            .custom-select option {
              background-color: #fff;
              /* Color de fondo */
              color: #333;
              /* Color del texto */
            }

            /* Estilo para el select cuando está desplegado */
            .custom-select:focus {
              outline: none;
              /* Eliminar el contorno al enfocar */
              border-color: #007bff;
              /* Cambiar el color del borde al enfocar */
              box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
              /* Efecto de sombra al enfocar */
            }

            .cabezeraCotiza {
              /* margin-top: 10px; */
              margin-left: 150px;
              margin-right: 150px;
              display: flex;
              justify-content: space-between;

            }
          </style>
          <div class="container py-4 text-center">
            <div class="og-contianer">
              <div class="row g-4 cabezerafilter">

                <!-- <div class="col-5"></div> -->
                <!-- buscador  -->
                <div class="col-5" style="display: none; justify-content: space-evenly;">
                  <select class="" id="optiona" placeholder="Tipo">
                    <option value="" selected="">Tipo todos</option>
                    <option name="Vienes" value="Vienes">Vienes</option>
                    <option name="servicios" value="servicios">servicios</option>
                  </select>
                  <select class="" id="optionb" placeholder="dependencia">
                    <option value="" selected="">dependencia todos</option>
                    <option name="Unamba-Imagen" value="Unamba-Imagen">Unamba-Imagen</option>
                    <option name="Unamba-RRH" value="Unamba-RRH">Unamba-RRH</option>
                    <option name="Unamba-PTT" value="Unamba-PTT">Unamba-PTT</option>
                    <option name="Unamba-Imagen" value="Unamba-Imagen">Unamba-Imagen</option>
                    <option name="Unamba-Tesorería" value="Unamba-Tesorería">Unamba-Tesorería</option>
                    <option name="Unamba-Planificación" value="Unamba-Planificación">Unamba-Planificación
                    </option>
                    <option name="Unamba-Proyeccion" value="Unamba-Proyeccion">Unamba-Proyeccion</option>
                    <option name="Unamba-Calidad" value="Unamba-Calidad">Unamba-Calidad</option>
                    <option name="Unamba-Desarrollo" value="Unamba-Desarrollo">Unamba-Desarrollo</option>
                    <option name="Unamba-Investigación" value="Unamba-Investigación">Unamba-Investigación
                    </option>
                    <option name="Unamba-Comunicaciones" value="Unamba-Comunicaciones">Unamba-Comunicaciones
                    </option>
                    <option name="Unamba-Producción" value="Unamba-Producción">Unamba-Producción
                    </option>
                    <option name="Unamba-Abastecimiento" value="Unamba-Abastecimiento">Unamba-Abastecimiento
                    </option>
                  </select>
                </div>
                <div class="col-auto">
                  <label for="campo" class="col-form-label">Buscar: </label>
                </div>
                <div class="col-auto">
                  <input type="text" name="campo" id="campo" class="form-control">
                </div>
                <!-- aqui iva el ganination  -->

              </div>
              <div class="row py-4">
                <div class="registropagina">
                  <div class="col-auto">
                    <label for="num_registros" class="col-form-label">Mostrar: </label>
                  </div>
                  <div class="col-auto">
                    <select name="num_registros" id="num_registros" class="form-select">
                      <option value="10">10</option>
                      <option value="25">25</option>
                      <option value="50">50</option>
                      <option value="100">100</option>
                    </select>
                  </div>

                  <div class="col-auto">
                    <label for="num_registros" class="col-form-label">registros </label>
                  </div>
                </div>

                <br>
                <br>
                <div class="col">

                  <table class="table table-sm table-bordered table-striped">
                    <thead style="background-color: #ffdc002e;
                          color: #033c77;
                          ">

                      <th class="sort asc"><i class="ri-expand-height-line" style=" color: red;"></i> Nro.
                        COTIZACIÓN </th>
                      <th class="sort asc"><i class="ri-expand-height-line" style=" color: red;"></i>
                        COTIZACIÓN</th>
                      <th class="sort asc"><i class="ri-expand-height-line" style=" color: red;"></i>
                        DEPENDENCIA</th>
                      <th class="sort asc"><i class="ri-expand-height-line" style=" color: red;"></i>
                        DESCRIPCIÓN</th>
                      <th class="sort asc"><i class="ri-expand-height-line" style=" color: red;"></i>
                        FECHA
                        PLAZO</th>
                      <th class="sort asc"><i class="ri-expand-height-line" style=" color: red;"></i>
                        OPCIONES
                      </th>

                    </thead>
                    <!-- El id del cuerpo de la tabla. -->
                    <tbody id="content" style="
                        color: #033c77;
                          ">
                      <!-- <h1>hola mundo</h1> -->
                    </tbody>
                  </table>
                </div>
              </div>

              <div class="row">
                <div class="col-6">
                  <label id="lbl-total"></label>
                </div>
                <div class="col-6" id="nav-paginacion"></div>
                <input type="hidden" id="pagina" value="1">
                <input type="hidden" id="orderCol" value="0">
                <input type="hidden" id="orderType" value="asc">
              </div>
            </div>
          </div>
        </main>

        <script>

          //es la obtencion de los elemtos al evento keyup del buscador
          getData()
          //es la obtencion evento keyup a buscador
          document.getElementById("campo").addEventListener("keyup", function () {
            getData()
          }, false)
          document.getElementById("optiona").addEventListener("change", function () {
            getData();
          }, false);
          document.getElementById("optionb").addEventListener("change", function () {
            getData();
          }, false);

          //es la obtencion de change a mostrar de la lista
          document.getElementById("num_registros").addEventListener("change", function () {
            getData()
          }, false)
          /* Peticion AJAX */
          function getData() {


            // el valor del campo 
            let input = document.getElementById("campo").value
            let inputa = document.getElementById("optiona").value
            console.log(inputa)
            let inputb = document.getElementById("optionb").value
            console.log(inputb)
            // el valor del registro a mostrar 
            let num_registros = document.getElementById("num_registros").value
            //contenido de la tabla
            let content = document.getElementById("content")
            // tabla pagina
            let pagina = document.getElementById("pagina").value
            // tabla ordenamiento
            let orderCol = document.getElementById("orderCol").value
            // tabla ordenamiento
            let orderType = document.getElementById("orderType").value
            if (pagina == null) {
              pagina = 1
            }
            // let url = "indexBusqueda.php"
            let url = "busqueda.php"

            let formaData = new FormData()
            formaData.append('campo', input)
            formaData.append('optiona', inputa)
            formaData.append('optionb', inputb)

            formaData.append('registros', num_registros)
            formaData.append('pagina', pagina)
            formaData.append('orderCol', orderCol)
            formaData.append('orderType', orderType)

            fetch(url, {
              method: "POST",
              body: formaData
            }).then(response => response.json())
              .then(data => {
                content.innerHTML = data.data
                document.getElementById("lbl-total").innerHTML = 'Mostrando ' + data.totalFiltro +
                  ' de ' + data.totalRegistros + ' registros'
                document.getElementById("nav-paginacion").innerHTML = data.paginacion
              }).catch(err => console.log(err))
          }
          function nextPage(pagina) {
            document.getElementById('pagina').value = pagina
            getData()
          }

          let columns = document.getElementsByClassName("sort")
          let tamanio = columns.length
          for (let i = 0; i < tamanio; i++) {
            columns[i].addEventListener("click", ordenar)
          }

          function ordenar(e) {
            let elemento = e.target

            document.getElementById('orderCol').value = elemento.cellIndex

            if (elemento.classList.contains("asc")) {
              document.getElementById("orderType").value = "asc"
              elemento.classList.remove("asc")
              elemento.classList.add("desc")
            } else {
              document.getElementById("orderType").value = "desc"
              elemento.classList.remove("desc")
              elemento.classList.add("asc")
            }
            getData()
          }

        </script>
        <footer class="cabezeraCotiza  ">
          <h5> Copyright 2024©
          </h5>
          <h5>
            <a href="https://www.unamba.edu.pe/"> Universidad Nacional Micaela Bastidas de Apurímac
            </a>

          </h5>

        </footer>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
          integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
          crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
          integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
          crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
          integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
          crossorigin="anonymous"></script>
      </div>
      <!-- traba fin   -->
    </article>
    <article class="larg">
      <div>
        <h3>mensaje contat<span class="entypo-down-open"></span></h3>
        <p>
          Lorem ipsum dolor sit amet, consectetur adipisicing elit. Temporibus
          iste quia incidunt ad provident ullam quo assumenda expedita quae
          sapiente ipsa qui esse similique! Modi obcaecati natus sapiente
          quaerat omnis.
        </p>
      </div>
      <?php
      ?>
    </article>

    <article class="larg">
      <div>
        <h3>mensaje ver<span class="entypo-down-open"></span></h3>
        <p>
          Lorem ipsum dolor sit amet, consectetur adipisicing elit. Temporibus
          iste quia incidunt ad provident ullam quo assumenda expedita quae
          sapiente ipsa qui esse similique! Modi obcaecati natus sapiente
          quaerat omnis.
        </p>
      </div>
      <?php
      ?>
    </article>


  </main>

</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
  integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"
  integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>

</html>