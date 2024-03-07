<?php
include("../conneccion/conection.php");

$query = "SELECT * FROM cotizacion";

$resultado = $conexion->query($query);


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="css/index.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

</head>

<body>
  <div class="bodyzz">
    <header><img src="img/banner.jpg" alt=""></header>
    <div class="containerOne">
      <button onclick="login()" class="adminin btn btn-dark">INICIAR SESION</button>
      <form class="row g-3 needs-validation" method="GET" novalidate>
        <h3>LISTA DE COTIZACIONES</h3>

        <div class="inputs row">
          <div class="col-md-2">
            <label for="validationCustom01" class="form-label">Nro Cotizacion:</label>
            <input type="text" class="form-control Ncotizacion" name="nroCotizacion" id="validationCustom01"
              placeholder="00000">
            <div class="valid-feedback">
              Looks good!
            </div>
          </div>
          <div class="col-md-2">
            <label for="validationCustom04" class="form-label">Estado:</label>
            <select class="form-select estado" id="validationCustom04">
              <option selected value="">Mostrar Todo</option>
              <option>Abiertas</option>
              <option>Cerradas</option>
            </select>
            <div class="invalid-feedback">
              Please select a valid state.
            </div>
          </div>
          <div class="col-md-3">
            <label for="validationCustom04" class="form-label">Fecha de Entrega y Acto Publico:</label>
            <select class="form-select" id="validationCustom04">
              <option selected disabled value="">Choose...</option>
              <option>...</option>
            </select>
            <div class="invalid-feedback">
              Please select a valid state.
            </div>
          </div>
          <div class="col-md-3">
            <label for="validationCustom04" class="form-label">Dependencia:</label>
            <select class="form-select" id="validationCustom04">
              <option selected value="">Minucipalidad Distrital de Tamburco</option>
            </select>
            <div class="invalid-feedback">
              Please select a valid state.
            </div>
          </div>
          <div class="col-md-2">
            <label for="validationCustom04" class="form-label">Año:</label>
            <select class="form-select" id="validationCustom04">
              <option selected disabled value="">Choose...</option>
              <option>...</option>
            </select>
            <div class="invalid-feedback">
              Please select a valid state.
            </div>
          </div>
        </div>
        <div class="buttons col-12">
          <button class="btn btn-info">Buscar</button>
          <button class="btn btn-danger">Limpiar</button>
        </div>
      </form>
    </div>
    <div class="ContainerTwo">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">Nro. COTIZACION</th>
            <th scope="col">DESCRIPCION DE PUBLICACION</th>
            <th scope="col">FECHA ENTREGA Y ACTO PUBLICO</th>
            <th scope="col">OPCIONES</th>
          </tr>
        </thead>
        <tbody class="tbody">
          <?php
          while ($row = $resultado->fetch_assoc()) {
            ?>
            <tr class="tr">
              <th scope="row">
                <?php echo $row['nroCotizacion']; ?>
              </th>
              <td>
                <h2>
                  <?php echo $row['descripcion']; ?>
                </h2>
                <p>Dependencia:
                  <?php echo $row['dependencia']; ?> <br> Fecha de Publicacion:
                  <?php echo $row['fechaEntrega']; ?>
                </p>
              </td>
              <td>
                <?php echo $row['fechaEntrega']; ?>
              </td>
              <td> <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                  data-bs-target="#exampleModal<?php echo $row['nroCotizacion'] ?>">
                  Descargar
                </button>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal<?php echo $row['nroCotizacion']; ?>" tabindex="-1"
                  aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Documentos</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <table class="table">
                          <thead>
                            <tr>
                              <th scope="col">Nro</th>
                              <th scope="col">Documento</th>
                              <th scope="col">Opciones</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>1</td>
                              <td>
                                <?php echo $row['pdfCot']; ?>
                              </td>
                              <td>
                                <?php echo '<a href="conection/' . $row['pdfCot'] . '" target="_blank">' . $row['nroCotizacion'] . ' - ' . $row['descripcion'] . '</a>'; ?>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
              </td>
            </tr>
          </tbody>
          <?php
          }
          ?>
      </table>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"
    integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS"
    crossorigin="anonymous"></script>
  <script src="js/index.js"></script>
</body>

</html>