<?php

  require 'controladores/controlador_trabajadores.php';

  if (!empty($_SESSION['id'])) {
    header('Location: inicio.php');
  }

  if (isset($_POST['correo'])) {
    $trabajadores = new trabajadores;
    $respuesta = $trabajadores->login($_POST['correo'], $_POST['clave']);

    if ($respuesta == 1) {
      header('Location: inicio.php');
    }
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

  <!-- CSS -->
  <style media="screen">
    body {
      background-image: url('img/bg.png');
      font-family: 'Roboto', sans-serif;
    }

    .contenedor {
      background: white;
      margin: auto;
      margin-top: 5%;
      width: 25%;
      height: 100%;
      box-shadow: 0px 0px 6px 0.5px #888888;
      border-radius: 5px;
    }
  </style>

</head>
<body>

  <div class="contenedor container">
    <img src="img/logo_ivss.png" alt="" style="width: 160px; margin-left: 70px; margin-bottom: 30px; margin-top: 30px;">

    <h3 class="text-center">José Antonio Vargas</h3>

    <?php if (isset($respuesta) && $respuesta == 2): ?>

      <div class="alert alert-danger alert-dismissible fade show" role="alert">
      Por favor introduzca su Correo y Clave correctamente.
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
      
    <?php endif ?>

    <form action="index.php" method="POST">
      <div class="form-group">
        <input type="text" class="form-control" name="correo" placeholder="Correo">
      </div>
      <div class="form-group">
        <input type="password" class="form-control" name="clave" placeholder="Contraseña">
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary btn-block">
          Ingresar
        </button>
      </div>
    </form>
  </div>

</body>
</html>
