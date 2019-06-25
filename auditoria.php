<?php

  session_start();
  include 'controladores/conexion.php';

  if ($_SESSION['nivel'] != 1) {

    header('Location: inicio.php');

  } else {

    $sql = "SELECT * FROM auditoria INNER JOIN trabajadores ON auditoria.id_trabajadores = trabajadores.id_trabajadores ORDER BY auditoria.id_auditoria DESC;";
    $con = mysqli_query($conexion, $sql) or die ('No se logró consultar la tabla: '.mysqli_error($conexion));

  }

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>IVSS José Antonio Vargas - Auditoría</title>
  <link rel="shortcut icon" type="image/png" href="img/logo_ivss.png">
  <!-- Bootstrap 4.3 -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="js/jquery3.3.1.js"></script>
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
          <th scope="col">ID</th>
          <th scope="col">Trabajador</th>
          <th scope="col">Accion</th>
          <th scope="col">Fecha</th>
          <th scope="col">Hora</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($auditoria = mysqli_fetch_assoc($con)) { ?>

          <tr>
            <th scope="row"><?php echo $auditoria['id_auditoria']; ?></th>
            <td><?php echo $auditoria['nombre_tra'].' '.$auditoria['apellido_tra']; ?></td>
            <td><?php echo $auditoria['accion_aud']; ?></td>
            <td><?php echo $auditoria['fecha_aud']; ?></td>
            <td><?php echo $auditoria['hora_aud']; ?></td>
          </tr>

        <?php } ?>
      </tbody>
    </table>
  </div>

</body>
</html>
