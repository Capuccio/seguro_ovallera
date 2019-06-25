<?php

  session_start();
  include 'controladores/conexion.php';

  if (isset($_GET['cita_x'])) {

    $sql = "UPDATE citas SET status_cit = '3' WHERE id_citas = '".$_GET['cita_x']."';";
    mysqli_query($conexion, $sql) or die ('No se logró actualizar el estatus de la cita: '.mysqli_error($conexion));

  }

  if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 2) {

    $sql = "SELECT * FROM ((citas INNER JOIN trabajadores ON citas.id_trabajadores = trabajadores.id_trabajadores) INNER JOIN pacientes ON citas.id_pacientes = pacientes.id_pacientes) ORDER BY Citas.id_citas DESC;";
    $con = mysqli_query($conexion, $sql) or die ('No se logró consultar la tabla: '.mysqli_error($conexion));

  } elseif ($_SESSION['nivel'] == 3) {

    $sql = "SELECT * FROM citas INNER JOIN pacientes ON citas.id_pacientes = pacientes.id_pacientes WHERE citas.id_trabajadores = '".$_SESSION['id']."' AND citas.status_cit = '1' ORDER BY citas.id_citas DESC;";
    $con = mysqli_query($conexion, $sql) or die ('No se logró consultar la tabla: '.mysqli_error($conexion));


  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>IVSS José Antonio Vargas - Citas</title>
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

  <?php if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 2): ?>

    <table class="table tabla container">
      <thead>
        <tr>
          <th scope="col">Nro</th>
          <th scope="col">Trabajador</th>
          <th scope="col">Paciente</th>
          <th scope="col">Fecha</th>
          <th scope="col">Hora</th>
          <th scope="col">Status</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($citas = mysqli_fetch_assoc($con)) { ?>

          <?php

            switch ($citas['status_cit']) {
              case '1':
                $clase = "table-primary";
                $estatus = "Activo";
                break;

              case '2':
                $clase = "table-success";
                $estatus = "Finalizado";
                break;

              case '3':
                $clase = "table-warning";
                $estatus = "Anulado";
                break;

              default:
                // code...
                break;
            }

          ?>

          <tr class="<?php echo $clase; ?>">
            <th scope="row"><?php echo $citas['id_citas']; ?></th>
            <td><?php echo $citas['nombre_tra'].' '.$citas['apellido_tra']; ?></td>
            <td><?php echo $citas['nombre_pac'].' '.$citas['apellido_pac']; ?></td>
            <td><?php echo $citas['fecha_cit']; ?></td>
            <td><?php echo $citas['hora_cit']; ?></td>
            <td><?php echo $estatus; ?></td>
          </tr>

        <?php } ?>
      </tbody>
    </table>

  <?php else: ?>

    <?php if (isset($_GET['cita_f']) && $_GET['cita_f'] == 1) { ?>

    <div class="alert alert-success" style="text-align: center; width: 82%; float: right;" role="alert">
      Cita finalizada correctamente
    </div>

    <?php } ?>

    <?php if (isset($_GET['cita_f']) && $_GET['cita_f'] == 2) { ?>

    <div class="alert alert-danger" style="text-align: center; width: 82%; float: right;" role="alert">
      La cita ha sido cancelada por motivos de ausencia del paciente
    </div>

    <?php } ?>

    <?php while ($citas = mysqli_fetch_assoc($con)) { ?>

      <div class="citas">
        <div class="citas-titulo">
          Cita #<?php echo $citas['id_citas']; ?>
        </div>
        <div class="citas-contenido">
          <b>Paciente:</b> <?php echo $citas['nombre_pac']. ' ' .$citas['apellido_pac']; ?><br>
          <b>C.I.:</b> <?php echo $citas['cedula_pac']; ?><br>
          <b>Fecha:</b> <?php echo $citas['fecha_cit']; ?><br>
          <b>Hora:</b> <?php echo $citas['hora_cit']; ?>
        </div>
        <div class="citas-pie">
          <button type="button" class="btn btn-success" onclick="document.location.href='visita_cita.php?cita=<?php echo $citas['id_citas']; ?>'">Confirmar <i class="fas fa-sign-in-alt"></i></button>
          <button type="button" class="btn btn-danger" onclick="document.location.href='citas.php?cita_f=2&cita_x=<?php echo $citas['id_citas']; ?>'"><i class="fas fa-times fa-lg"></i> Cancelar</button>
        </div>
      </div>

    <?php } ?>


  <?php endif; ?>

</body>
</html>
