<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/viewTable.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>

    <div class="button-close">
        <a href="../Admin/admin.php" class="btn btn-info"><i class="bi bi-backspace-fill"></i>REGRESAR</a>
    </div>
    <!-- <a href="../../dashboard/dashboard.php"></a> -->
  
    <div class="container">
      <div class="title">
      <img src="../img/Abancay-logo.png" alt="">
       <h1>TABLA DE CONTENIDO</h1>
        <img src="../img/Abancay-logo.png" alt="">    
      </div>
      <table class="table table-light">
        <thead>
          <tr>
            <th scope="col">Nro Cotizacion</th>
            <th scope="col">Descripcion de Cotizacion</th>
            <th scope="col">Fecha de Entrega</th>
            <th scope="col" colspan="2" style="text-align: center;">Handle</th>
          </tr>
        </thead>
        <tbody>
            <?php
              include("conection.php");

              $query = "SELECT * FROM cotizacion";
              $resultado = $conexion->query($query);

              while($row = $resultado->fetch_assoc()){

            ?>
          <tr>
            <th scope="row"><?php echo $row['nroCotizacion'];?></th>
            <td><?php echo $row['descripcion']; ?></td>
            <td><?php echo $row['fechaEntrega'];?></td>
            <td><a href="modificar.php?nroCotizacion=<?php echo $row['nroCotizacion']; ?>" class="btn btn-warning">EDITAR</a></td>
            <td><a href="eliminar.php?nroCotizacion=<?php echo $row['nroCotizacion']; ?>" class="btn btn-danger">ELIMINAR</a></td>
          </tr>
         <?php
            }
         ?>
        </tbody>
      </table>

    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
    
</body>
</html>