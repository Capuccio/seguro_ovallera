<?php

  require 'controladores/controlador_trabajadores.php';

  if ($_SESSION['nivel'] != 1 && $_SESSION['nivel'] != 2) {
    header('Location: inicio.php');
  }

  if (isset($_POST['nombre'])) {

    $trabajadores = new trabajadores;
    $respuesta = $trabajadores->registrar_insumos($_POST['nombre'], $_POST['cantidad'], $_POST['fecha']);

    if ($respuesta == 1) {
      header('Location: inicio.php?registro=5');
    }

  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>IVSS José Antonio Vargas - Insumos</title>
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

  <style media="screen">
    input::-webkit-inner-spin-button {
      display: none;
    }
  </style>

</head>
<body>

  <?php include 'plantillas/menu.php'; ?>

  <div class="container col-md-8 center-block formulario">

    <div class="alert alert-danger" id="alerta" style="display: none;" role="alert">
      <strong>Debe rellenar todos los campos</strong>
    </div>

    <div class="alert alert-danger" id="alerta_2" style="display: none;" role="alert">
      <strong>El insumo escrito ya está registrado</strong>
    </div>

    <form action="registrar_insumos.php" id="registrar_insumos" method="POST">

      <div class="form-row">
        <div class="form-group col-md-4">
          <label for="inputEmail4">Nombre del Insumo</label>
          <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Guantes">
          <div class="valid-feedback">
            Insumo no registrado
          </div>
          <div class="invalid-feedback">
            Insumo registrado
          </div>
        </div>
        <div class="form-group col-md-4">
          <label for="inputPassword4">Cantidad del Insumo</label>
          <input type="number" class="form-control" id="cantidad" name="cantidad" placeholder="20">
        </div>
        <div class="form-group col-md-4">
          <label for="inputPassword4">Fecha de Vencimiento</label>
          <input type="date" class="form-control" id="fecha" name="fecha">
        </div>
      </div>

    <button type="button" class="btn btn-primary btn-block" onclick="confirmar();">Registrar Insumo</button>
    </form>
  </div>

  <script type="text/javascript">

  var equipo;

  document.getElementById('nombre').addEventListener('keyup', function() {

    $.ajax({
      url:'manejadores/manejador_trabajadores.php',
      type:'POST',
      data:`nombre=${this.value}&busqueda=insumo`
    }).done(function(insumo){
      console.log(insumo);
      if (insumo == 1) {
        equipo = insumo;
        document.getElementById('nombre').classList.add("is-valid");
      } else if (insumo == 2) {
        equipo = insumo;
        document.getElementById('nombre').classList.add("is-invalid");
      }

    });

  });

  const confirmar = () => {

    if ($("#nombre").val() == "" || $("#cantidad").val() == "" || $("#fecha").val() == "") {

      document.getElementById('alerta').style.display = "";

    } else if (equipo == 2) {

      document.getElementById('alerta_2').style.display = "";

    } else {

      document.getElementById('registrar_insumos').submit();

    }

  }

  </script>

</body>
</html>
