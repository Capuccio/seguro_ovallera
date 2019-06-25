<?php

  session_start();
  include 'controladores/conexion.php';

  if ($_SESSION['nivel'] != 1 && $_SESSION['nivel'] != 2) {
    header('Location: inicio.php');
  }

  $sql = "SELECT * FROM insumos;";
  $con = mysqli_query($conexion, $sql) or die ('No se logró consultar los insumos');

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>IVSS José Antonio Vargas - Inventario</title>
  <link rel="shortcut icon" type="image/png" href="img/logo_ivss.png">
  <!-- Bootstrap 4.3 -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.4.0.min.js" charset="utf-8"></script>
  <script src="js/bootstrap.min.js" charset="utf-8"></script>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="css/all.css">
  <script src="js/all.js" charset="utf-8"></script>

  <!-- CSS -->
  <link rel="stylesheet" href="css/estilos.css">

</head>
<body>

  <?php include 'plantillas/menu.php'; ?>

  <div class="tabla container">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">Nombre del Insumo</th>
          <th scope="col">Cantidad existente</th>
          <th scope="col">Fecha de Vencimiento</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($inventario = mysqli_fetch_assoc($con)) { ?>

          <tr>
            <th scope="row"><?php echo $inventario['nombre_ins']; ?></th>
            <td><?php echo $inventario['cantidad_ins']; ?></td>
            <td><?php echo $inventario['fecha_vencimiento_ins']; ?></td>
          </tr>

        <?php } ?>
      </tbody>
    </table>
  </div>

</body>
</html>
