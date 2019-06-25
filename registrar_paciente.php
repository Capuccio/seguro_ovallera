<?php

  include 'controladores/controlador_pacientes.php';

  if ($_SESSION['nivel'] != 1 && $_SESSION['nivel'] != 2) {
    header('Location: index.php');
  }

  if (isset($_POST['nombre'])) {
    $trabajadores = new pacientes;
    $respuesta = $trabajadores->registrar($_POST['nombre'], $_POST['apellido'], $_POST['cedula'], $_POST['correo'], $_POST['celular'], $_POST['telefono'], $_POST['sexo'], $_POST['edad'], $_POST['direccion']);

    if ($respuesta == 1) {
      header('Location: inicio.php?registro=3');
    }
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>IVSS José Antonio Vargas - Registrar Doctor</title>
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
      <strong>Por favor revisar los campos donde se le muestra el error</strong>
    </div>

    <form action="registrar_paciente.php" id="registrar_paciente" method="POST">
      <div class="form-row">
        <div class="form-group col-md-4">
          <label for="inputEmail4">Nombre</label>
          <input type="text" class="form-control" id="nombre" onkeypress="return validLetras(event)" name="nombre" placeholder="Nombre">
        </div>
        <div class="form-group col-md-4">
          <label for="inputPassword4">Apellido</label>
          <input type="text" class="form-control" id="apellido" onkeypress="return validLetras(event)" name="apellido" placeholder="Apellido">
        </div>
        <div class="form-group col-md-4">
          <label for="inputPassword4">Cédula</label>
          <input type="text" class="form-control" id="cedula" name="cedula" placeholder="12345678" maxlength="8">
          <div class="valid-feedback">
            Cédula no registrada
          </div>
          <div id="cedula_invalida" class="invalid-feedback">

          </div>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-4">
          <label for="inputAddress">Correo</label>
          <input type="email" class="form-control" id="correo" name="correo" placeholder="ejemplo@gmail.com">
          <div class="valid-feedback">
            Correo disponible
          </div>
          <div class="invalid-feedback">
            Correo ya registro
          </div>
        </div>
        <div class="form-group col-md-4">
          <label for="inputPassword4">Celular</label>
          <input type="number" class="form-control" id="celular" onkeypress="return validNumeros(event, this)" name="celular" placeholder="04121234567" maxlength="12">
        </div>
        <div class="form-group col-md-4">
          <label for="inputPassword4">Teléfono</label>
          <input type="number" class="form-control" id="telefono" onkeypress="return validNumeros(event, this)" name="telefono" placeholder="02431234567" maxlength="12">
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-4">
          <label for="inputPassword4">Sexo</label>
          <select class="custom-select" name="sexo">
            <option value="1">Masculimo</option>
            <option value="2">Femenino</option>
          </select>
        </div>
        <div class="form-group col-md-4">
          <label for="inputPassword4">Edad</label>
          <input type="text" class="form-control" id="edad" name="edad" placeholder="23">
        </div>
        <div class="form-group col-md-4">
          <label for="">Dirección</label>
          <textarea class="form-control" id="direccion" name="direccion" rows="3" placeholder="Avenida, Calle, etc."></textarea>
        </div>
      </div>
    <button type="button" class="btn btn-primary btn-block" onclick="confirmar();">Registrar Paciente</button>
    </form>
  </div>

  <script type="text/javascript">

    var correo_existente, cedula_existente;

    $("#cedula").on('keyup', function(event) {
      var cedula = $("#cedula").val();

      $.ajax({
        url:'manejadores/manejador_pacientes.php',
        type:'POST',
        data:`cedula=${cedula}&busqueda=cedula`
      }).done(function(busq_ced){

        if (busq_ced == 1) {

          $("#cedula").removeClass('is-invalid');
          $("#cedula").addClass('is-valid');

          cedula_existente = 1;

        } else if (busq_ced == 2) {

          $("#cedula").removeClass('is-valid');
          $("#cedula").addClass('is-invalid');
          $("#cedula_invalida").html('Cédula ya registrada');

          cedula_existente = 2;

        } else if (busq_ced == 3) {

          $("#cedula").removeClass('is-valid');
          $("#cedula").addClass('is-invalid');
          $("#cedula_invalida").html('Insertar sólo números');

          cedula_existente = 3;

        }

      });
    });

    document.getElementById('correo').addEventListener('keyup', function() {

      let input = document.getElementById('correo');

      $.ajax({
        url:'manejadores/manejador_pacientes.php',
        type:'POST',
        data:`correo=${this.value}&busqueda=correo`
      }).done(function(busq_cor){

        if (busq_cor == 1) {
          input.classList.remove('is-invalid');
          input.classList.add('is-valid');
          correo_existente = 1;
        } else if (busq_cor == 2) {
          input.classList.remove('is-valid');
          input.classList.add('is-invalid');
          correo_existente = 2;
        }

      });

    });


    const validLetras = (event) => {

      var noValido = ['.', ',', '+', '-', '?', '¿', '=', '"', "'", '!', '¡', '$', '#', '%', '&', '/', '=', '´', '*', '¨', '{', '}', '[', ']', ')', '('];

      if (event.keyCode >= 48 && event.keyCode <= 57) {
        return false;
      } else {

        for (var i = 0; i < noValido.length; i++) {

          if (event.key === noValido[i]) {
            return false;
          }

        }

      }

    }

    const validNumeros = (event, max) => {

      var noValido = ['e', '.', ',', '+', '-'];
      var maxlength = max.value;

      if (maxlength.length == 11) {

        return false;

      } else {

        for (var i = 0; i < noValido.length; i++) {

          if (event.key === noValido[i]) {
            return false;
          }

        }

      }

    }

    function confirmar() {

      if ($("#nombre").val() == "" || $("#apellido").val() == "" || $("#cedula").val() == "" || $("#correo").val() == "" || $("#celular").val() == "" || $("#telefono").val() == "" || $("#edad").val() == "" || $("#direccion").val() == "")
      {

        document.getElementById('alerta').style.display="";

      }  else if (correo_existente == 2 || cedula_existente == 2 || cedula_existente == 3) {

        document.getElementById('alerta_2').style.display="";

      } else {
        document.getElementById('registrar_paciente').submit();
      }

    }

  </script>
</body>
</html>
