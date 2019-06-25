<?php

  session_start();
  require 'controladores/conexion.php';

  if (empty($_SESSION['id'])) {
    header('Location: index.php');
  } elseif ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 2) {

    $sql_trabajadores = "SELECT COUNT(id_trabajadores) as total FROM trabajadores;";
    $con_trabajadores = mysqli_query($conexion, $sql_trabajadores) or die ('No se logró consultar la cantidad de trabajdores: '.mysqli_error($conexion));
    $trabajadores = mysqli_fetch_assoc($con_trabajadores);

    $sql_pacientes = "SELECT COUNT(id_pacientes) as total FROM pacientes;";
    $con_pacientes = mysqli_query($conexion, $sql_pacientes) or die ('No se logró consultar la cantidad de trabajdores: '.mysqli_error($conexion));
    $pacientes = mysqli_fetch_assoc($con_pacientes);

    $sql_auditoria = "SELECT COUNT(id_auditoria) as total FROM auditoria;";
    $con_auditoria = mysqli_query($conexion, $sql_auditoria) or die ('No se logró consultar la cantidad de trabajdores: '.mysqli_error($conexion));
    $auditoria = mysqli_fetch_assoc($con_auditoria);

  } else {

    $citas_sql = "SELECT COUNT(id_citas) as citas FROM citas WHERE id_trabajadores = '".$_SESSION['id']."' AND status_cit = '1';";
    $citas_con = mysqli_query($conexion, $citas_sql) or die ('No se logró consultar las citas: '.mysqli_error($conexion));
    $citas = mysqli_fetch_assoc($citas_con);

  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>IVSS José Antonio Vargas</title>
  <link rel="shortcut icon" type="image/png" href="img/logo_ivss.png">

  <!-- Bootstrap 4.3 -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="js/jquery3.3.1.js" charset="utf-8"></script>
  <script src="js/bootstrap.min.js" charset="utf-8"></script>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="css/all.css">
  <script src="js/all.js" charset="utf-8"></script>

  <!-- CSS -->
  <link rel="stylesheet" href="css/estilos.css">

  <style media="screen">
    .tarjeta-ini:hover {
      box-shadow: 4px 4px 15px 2px gray;
      cursor: pointer;
    }

    a:link, a:visited {
      text-decoration: none;
      color: rgb(10, 10, 10);
    }

    .card {
      border-radius: 10px;
    }
  </style>

</head>
<body>

  <?php include 'plantillas/menu.php'; ?>

  <div class="contenido">

    <?php

      if (isset($_GET['registro']) && $_GET['registro'] == 1) { ?>

        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Doctor</strong> registrado correctamente <strong>Clave: doctor</strong>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

    <?php } ?>

    <?php

      if (isset($_GET['registro']) && $_GET['registro'] == 2) { ?>

        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Secretario/a</strong> registrado correctamente <strong>Clave: secretario</strong>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

    <?php } ?>

    <?php if (isset($_GET['registro']) && $_GET['registro'] == 3): ?>

      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Paciente</strong> registrado correctamente
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

    <?php endif; ?>

    <?php if (isset($_GET['registro']) && $_GET['registro'] == 4): ?>

      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Cita</strong> registrada correctamente
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

    <?php endif; ?>

    <?php if (isset($_GET['registro']) && $_GET['registro'] == 5): ?>

      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Insumo</strong> registrado correctamente
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

    <?php endif; ?>

    <div class="row">

      <?php if ($_SESSION['nivel'] == 1): ?>

      <div class="col-sm-4">
          <div class="card bg-light text-center p-3 tarjeta-ini" style="width: 18rem;">
            <a href="pacientes.php">
            <img src="img/pacientes.png" class="card-img-top" alt="...">
            <div class="card-body">
              <p class="card-text h2">Pacientes</p>
              <p class="card-text h4"><?php echo $pacientes['total']; ?></p>
            </div>
            </a>
          </div>
      </div>

      <div class="col-sm-4">
          <div class="card bg-light text-center p-3 tarjeta-ini" style="width: 18rem;">
            <a href="trabajadores.php">
            <img src="img/trabajadores.png" class="card-img-top" alt="...">
            <div class="card-body">
              <p class="card-text h2">Trabajadores</p>
              <p class="card-text h4"><?php echo $trabajadores['total']; ?></p>
            </div>
            </a>
          </div>
      </div>

        <div class="col-sm-4">
          <div class="card bg-light text-center p-3 tarjeta-ini" style="width: 18rem;">
            <a href="auditoria.php">
            <img src="img/data.png" class="card-img-top" alt="...">
            <div class="card-body">
              <p class="card-text h2">Auditoria</p>
              <p class="card-text h4"><?php echo $auditoria['total']; ?></p>
            </div>
            </a>
          </div>
      </div>
        
      <?php endif ?>

      <?php if ($_SESSION['nivel'] == 3): ?>

      <div class="col-sm-12" style="margin-left: 30%;">
          <div class="card bg-light text-center p-3 tarjeta-ini" style="width: 18rem;">
            <a href="citas.php">
            <img src="img/calendario.png" class="card-img-top" alt="...">
            <div class="card-body">
              <p class="card-text h2">Citas</p>
              <p class="card-text h4"><?php echo $citas['citas']; ?></p>
            </div>
            </a>
          </div>
      </div>

      <?php endif ?>

    </div>

  </div>

</body>
</html>
