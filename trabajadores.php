<?php

  session_start();
  include 'controladores/conexion.php';

  if ($_SESSION['nivel'] != 1 && $_SESSION['nivel'] != 2) {

    header('Location: inicio.php');

  } else {

    $sql = "SELECT * FROM trabajadores ORDER BY id_trabajadores DESC;";
    $con = mysqli_query($conexion, $sql) or die ('No se logró consultar la tabla: '.mysqli_error($conexion));

  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>IVSS José Antonio Vargas - Trabajadores</title>
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
          <th scope="col">Cédula</th>
          <th scope="col">Nombre</th>
          <th scope="col">Correo</th>
          <th scope="col">Celular</th>
          <th scope="col">Teléfono</th>
          <th scope="col">Sexo</th>
          <th scope="col">Edad</th>
          <th scope="col">Direccion</th>
          <th scope="col">Especialidad</th>
          <th scope="col">Turno</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($trabajador = mysqli_fetch_assoc($con)) { ?>

          <tr>
            <th scope="row"><?php echo $trabajador['cedula_tra']; ?></th>
            <td><?php echo $trabajador['nombre_tra'] .' '. $trabajador['apellido_tra']; ?></td>
            <td><?php echo $trabajador['correo_tra']; ?></td>
            <td><?php echo $trabajador['celular_tra']; ?></td>
            <td><?php echo $trabajador['telefono_tra']; ?></td>
            <td><?php echo $trabajador['sexo_tra']; ?></td>
            <td><?php echo $trabajador['edad_tra']; ?></td>
            <td><?php echo $trabajador['direccion_tra']; ?></td>
            <td><?php echo $trabajador['especialidad_tra']; ?></td>
            <td><?php echo $trabajador['turno_tra']; ?></td>
          </tr>

        <?php } ?>
      </tbody>
    </table>
  </div>

</body>
</html>
