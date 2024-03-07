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
if (isset($_GET['deleteMesage'])) {
  $delete_id = $_GET['deleteMesage'];
  $delete_message = $conn->prepare("DELETE FROM `messages` WHERE id = ?");
  $delete_message->execute([$delete_id]);
  header('location:dashboard.php');
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
  header('location:dashboard.php');
}
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
  header('location:dashboard.php');
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

    .mesageForm {
      display: flex;
      flex-direction: column;
      text-align: center;

    }

    .boxMesage {

      padding: 10px;
      margin: 10px;
      color: #377bbf;
    }

    .botonMesage {
      margin: 25px;
      padding: 5px;
      width: 200px;
      text-decoration: none;

      color: white;
      background: #0c1926;
    }

    .botonMesage:hover {
      color: #0c1926;
      background: white;
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

        <li>
          <a href="javascript:void(0);">Solicitudes</a>
        </li>

        <li class="<?= $row['tadmin_tipo'] ?>">
          <a href=" javascript:void(0);">Control</a>
        </li>

        <li class="<?= $row['tadmin_tipo'] ?>">
          <a href="javascript:void(0);">Usuarios</a>
        </li>
        <li>
          <a href="javascript:void(0);">Reportar</a>
        </li>
        <li class="<?= $row['tadmin_tipo'] ?>">
          <a href="javascript:void(0);">Ver Reportes</a>
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

        .contenido {
          display: none;
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
        <h3 onclick="mostrarContenido()"><i class="ri-chat-settings-fill" style="    color: #18c8a4;"></i> Tome un
          momento para
          familiarizarse con las recomendaciones. <i class="ri-skip-down-line" style="    color: red;"></i></h3>
        <div class="contenido">
          <p class="contenido">
            <i class="ri-asterisk" style="    color: #18c8a4;"></i> Asegúrate completar la cotización, sean claras y
            fáciles de entender.
          </p>
          <p class="contenido">
            <i class="ri-asterisk" style="    color: #18c8a4;"></i> Está protegido contra alteraciones de scripts
            maliciosos, garantizando así la seguridad de sus datos.
          </p>
          <p class="contenido">
            <i class="ri-asterisk" style="    color: #18c8a4;"></i> Está supervisado por un control de actividades.
          </p>
          <p class="contenido">
            <i class="ri-asterisk" style="    color: #18c8a4;"></i> Comunicate con soporte en caso de que tengan
            preguntas
            o necesiten ayuda para completar la cotización.
          </p>
        </div>
      </div>

      <?php include '../Cotizacion/Admin/admin.php'; ?>
    </article>
    <!-- ARTICULO 7 -->
    <article class="larg">

      <h3 onclick="mostrarContenido()"><i class="ri-chat-settings-fill" style="    color: #18c8a4;"></i> Tome un
        momento para
        familiarizarse con las recomendaciones. <i class="ri-skip-down-line" style="    color: red;"></i></h3>
      <div class="contenido">
        <p class="contenido">
          <i class="ri-asterisk" style="    color: #18c8a4;"></i> Las cotizaciones no finalizadas el proceso de
          postulación no aparecerán.
        </p>
        <p class="contenido">
          <i class="ri-asterisk" style="    color: #18c8a4;"></i> Una vez ingresado se estará realizando fase de
          concurso, evaluación de expedientes.
        </p>
        <p class="contenido">
          <i class="ri-asterisk" style="    color: #18c8a4;"></i> Solo puede eliminar una sola vez, limpie las
          solicitudes solo cuando finalice la revisión.
        </p>
      </div>

      <?php
      include '../Cotizacion/Admin/codigosDisponibles.php';
      ?>
    </article>
    <!-- ARTICULO 7 -->
    <article class="larg <?= $row['tadmin_tipo'] ?>">
      <div>
        <h3 onclick="mostrarContenido()"><i class="ri-chat-settings-fill" style="    color: #18c8a4;"></i> Tome un
          momento para
          familiarizarse con las recomendaciones. <i class="ri-skip-down-line" style="    color: red;"></i></h3>
        <p class="contenido">
          <i class="ri-asterisk" style="    color: #18c8a4;"></i> Los registros se eliminaran periodicamente
          automatiamente.
        </p>
      </div>

      <?php
      include '../Cotizacion/Admin/verControl.php';

      ?>
    </article>
    <!-- ARTICULO 7 -->
    <article class="larg <?= $row['tadmin_tipo'] ?>">
      <div>
        <h3 onclick="mostrarContenido()"><i class="ri-chat-settings-fill" style="    color: #18c8a4;"></i> Tome un
          momento para
          familiarizarse con las recomendaciones. <i class="ri-skip-down-line" style="    color: red;"></i></h3>
        <div class="contenido">
          <p class="contenido">
            <i class="ri-asterisk" style="    color: #18c8a4;"></i> Asegúrate completar la cotización, sean claras y
            fáciles de entender.
          </p>
          <p class="contenido">
            <i class="ri-asterisk" style="    color: #18c8a4;"></i> Está protegido contra alteraciones de scripts
            maliciosos, garantizando así la seguridad de sus datos.
          </p>
          <p class="contenido">
            <i class="ri-asterisk" style="    color: #18c8a4;"></i> Está supervisado por un control de actividades.
          </p>
          <p class="contenido">
            <i class="ri-asterisk" style="    color: #18c8a4;"></i> Comunicate con soporte en caso de que tengan
            preguntas
            o necesiten ayuda para completar la cotización.
          </p>
        </div>
      </div>
      <!-- traba inicio   -->
      <?php
      include '../Cotizacion/Admin/verUsuarios/usuarioIndex.php';

      ?>
      <!-- traba fin   -->
    </article>
    <article class="larg">
      <div>
        <h3 onclick="mostrarContenido()">mensaje contat<span class="entypo-down-open"></span></h3>
        <p class="contenido">
          Enviar un message AL administrador.
        </p>
      </div>
      <form action="profile/sendMesage.php" method="post" class="mesageForm">
        <h3>REPORTAR</h3>
        <input type="text" name="name" placeholder="&#xf007; ponga su nombre" required maxlength="20" class="boxMesage">
        <span id="icon">
          <i class="fas fa-key"></i>
        </span>
        <textarea name="msg" class="boxMesage" placeholder="&#xf036; detalle su mensage" cols="30" rows="10"></textarea>
        <input type="submit" class="botonMesage" value="enviar mensage" name="send">
      </form>
    </article>
    <article class="larg <?= $row['tadmin_tipo'] ?>">
      <section class="contacts">
        <h1 class="heading">mensajes</h1>
        <style>
          @import url('https://fonts.googleapis.com/css2?family=Changa:wght@200..800&family=Saira+Condensed:wght@200&display=swap');

          .heading {
            font-family: "Changa", sans-serif;
          }

          #icon {
            position: absolute;
            display: block;
            bottom: .5rem;
            right: 1rem;

            user-select: none;
            cursor: pointer;
          }

          .mensage {
            /* max-width: 600px;
            margin: 20px auto; */
            font-family: "Changa", sans-serif;
            background-color: #ffffff;
            box-shadow: 0 2px 7px 0px rgb(0 230 255 / 32%);
            border-radius: 8px;
            padding: 20px;
          }

          .mensage h4 {
            margin: 10px 0;
            font-weight: bold;
            color: #1a718375;
          }

          .mensage span {
            font-weight: normal;
            color: #0c1926b3;
          }
        </style>
        <div class="box-container mensage">


          <?php
          $select_messages = $conn->prepare("SELECT * FROM `messages`");
          $select_messages->execute();
          if ($select_messages->rowCount() > 0) {
            while ($fetch_message = $select_messages->fetch(PDO::FETCH_ASSOC)) {
              ?>
              <h4><i class="ri-code-line" style="color: #d97979;"></i>&nbsp;&nbsp;Código de mensaje
                :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <span>
                  <?= $fetch_message['id']; ?>
                </span>
              </h4>
              <h4><i class="ri-anticlockwise-line" style="color: #d97979;"></i>&nbsp;&nbsp;Enviado desde la cuenta de
                :&nbsp;&nbsp;&nbsp;&nbsp;<span>
                  <?= $fetch_message['user_id']; ?>
                </span></h4>
              <h4><i class="ri-message-2-line" style="color: #d97979;"></i>&nbsp;&nbsp;mensaje
                :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <span>
                  <?= $fetch_message['message']; ?>
                </span>
              </h4>

              <h4><i class="ri-user-3-line" style="color: #d97979;"></i>&nbsp;&nbsp;Nombre emitente
                :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <span>
                  <?= $fetch_message['name']; ?>
                </span>
              </h4>
              <h4><i class="ri-calendar-schedule-line" style="color: #d97979;"></i>&nbsp;&nbsp;UTF hora y fecha
                :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <span>
                  <?= $fetch_message['mensageFehca']; ?>
                </span>
              </h4>

              <a href="dashboard.php?deleteMesage=<?= $fetch_message['id']; ?>"
                onclick="return confirm('delete this message?');" class="botonMesage">ELIMINAR</a>

              <?php
            }
          } else {
            echo '<p class="empty">you have no messages</p>';
          }
          ?>
        </div>
      </section>



    </article>


  </main>
  <script>
    function mostrarContenido() {
      var contenidos = document.querySelectorAll('.contenido');
      contenidos.forEach(function (contenido) {
        if (contenido.style.display === 'none') {
          contenido.style.display = 'block';
        } else {
          contenido.style.display = 'none';
        }
      });
    }
  </script>
</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
  integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"
  integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>

</html>