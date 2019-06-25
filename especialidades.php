<?php

  session_start();
  include 'controladores/conexion.php';

  if ($_SESSION['nivel'] != 1 && $_SESSION['nivel'] != 2) {

    header('Location: inicio.php');

  } else {

    $sql = "SELECT DISTINCT especialidad_tra FROM trabajadores WHERE nivel_tra = 3;";
    $con = mysqli_query($conexion, $sql) or die ('No se logró consultar la tabla: '.mysqli_error($conexion));

  }

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>IVSS José Antonio Vargas - Especialidades</title>
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
          <th scope="col">Especialidades</th>
          <th scope="col">Nro. Doctores</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($especialidad = mysqli_fetch_assoc($con)) {

          $sql_count = "SELECT COUNT(especialidad_tra) as doctores FROM trabajadores WHERE especialidad_tra = '".$especialidad['especialidad_tra']."' AND nivel_tra = 3;";
          $con_count = mysqli_query($conexion, $sql_count) or die ('No se logró contar la tabla: '.mysqli_error($conexion));
          $count = mysqli_fetch_assoc($con_count);

        ?>

          <tr>
            <th scope="row"><?php echo $especialidad['especialidad_tra']; ?></th>
            <td><?php echo $count['doctores']; ?></td>
          </tr>

        <?php } ?>
      </tbody>
    </table>
  </div>

</body>
</html>
