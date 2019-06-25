<?php

  include 'controladores/controlador_trabajadores.php';

  if ($_SESSION['nivel'] != 1 && $_SESSION['nivel'] != 2) {
    header('Location: inicio.php');
  }

  if (isset($_POST['cedula_doctor'])) {
    $trabajadores = new trabajadores;
    $respuesta = $trabajadores->registrar_cita($_POST['cedula_doctor'], $_POST['cedula_paciente'], $_POST['fecha'], $_POST['hora']);

    if ($respuesta == 3) {
      header('Location: inicio.php?registro=4');
    }
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>IVSS José Antonio Vargas - Registrar Citas</title>
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
    input[list]::-webkit-calendar-picker-indicator {
      display: none;
    }
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
      <strong>La hora y la fecha deben colocarse correctamente</strong>
    </div>

    <?php if (isset($respuesta) && $respuesta == 1): ?>
      <div class="alert alert-danger" style="display: none;" role="alert">
        <strong>El Doctor insertado no existe</strong>
      </div>
    <?php endif; ?>

    <?php if (isset($respuesta) && $respuesta == 2): ?>
      <div class="alert alert-danger" style="display: none;" role="alert">
        <strong>El Paciente insertado no existe</strong>
      </div>
    <?php endif; ?>

    <form action="registrar_citas.php" id="registrar_cita" method="POST">
      <div class="form-row">
        <div class="form-group col-md-6">
          <label>Turno del Doctor</label>
          <select class="form-control" id="turno_trabajador">
            <option value="0">Seleccionar Turno</option>
            <option value="1">Mañana</option>
            <option value="2">Tarde</option>
          </select>
        </div>
        <div class="form-group col-md-6">
          <label>Nombre del Doctor</label>
          <input list="trabajadores_name" class="form-control" id="nombre_doctor" name="cedula_doctor" placeholder="Nombre del Doctor" disabled>
          <datalist id="trabajadores_name">
          </datalist>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-12">
          <label for="inputPassword4">Nombre del Paciente</label>
          <input list="pacientes_name" class="form-control" id="nombre_paciente" name="cedula_paciente" placeholder="Paciente">
          <datalist id="pacientes_name">
          </datalist>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="inputAddress">Fecha</label>
          <input type="date" class="form-control" id="fecha_cita" name="fecha">
        </div>
        <div class="form-group col-md-6">
          <label for="inputPassword4">Hora</label>
          <input type="text" class="form-control" id="hora_cita" name="hora" maxlength="5" placeholder="00:00">
        </div>
      </div>
    <button type="button" class="btn btn-primary btn-block" onclick="confirmar();">Registrar Cita</button>
    </form>
  </div>

  <script type="text/javascript">

    var turno;

    document.getElementById('nombre_doctor').addEventListener('keyup', function() {

      var doctor = new FormData();
      doctor.append('busqueda', 'trabajador');
      doctor.append('nombre', this.value);
      doctor.append('turno', turno);

      fetch('manejadores/manejador_trabajadores.php', {
        method:'POST',
        body: doctor
      })
      .then(response => response.json())
      .then(function(datos){

        var lista_doc = document.getElementById('trabajadores_name');

        while (lista_doc.hasChildNodes()) {
          lista_doc.removeChild(lista_doc.firstChild);
        }

        for (var i = 0; i < datos.Trabajadores.length; i++) {
          var opcion = document.createElement("option");
          opcion.value = `${datos.Trabajadores[i].cedula_tra}`;
          opcion.innerHTML = `${datos.Trabajadores[i].nombre_tra} ${datos.Trabajadores[i].apellido_tra} - ${datos.Trabajadores[i].especialidad_tra}`;
          document.getElementById('trabajadores_name').appendChild(opcion);
        }

      })
      .catch(err => console.log(err))

    });

    document.getElementById('nombre_paciente').addEventListener('keyup', function() {

      var paciente = new FormData();
      paciente.append('busqueda', 'paciente');
      paciente.append('nombre', this.value);

      fetch('manejadores/manejador_pacientes.php', {
        method:'POST',
        body: paciente
      })
      .then(res => res.json())
      .then(function(pacientes){

        var lista_pac = document.getElementById('pacientes_name');

        while (lista_pac.hasChildNodes()) {
          lista_pac.removeChild(lista_pac.firstChild);
        }

        for (var i = 0; i < pacientes.Pacientes.length; i++) {
          var opcion = document.createElement("option");
          opcion.value = pacientes.Pacientes[i].cedula_pac;
          opcion.innerHTML = `${pacientes.Pacientes[i].nombre_pac} ${pacientes.Pacientes[i].apellido_pac}`;
          document.getElementById('pacientes_name').appendChild(opcion);

        }

      })
      .catch(err => console.log(err))

    });

    document.getElementById('turno_trabajador').addEventListener('change', function() {

      var lista_doc = document.getElementById('trabajadores_name');

      if (this.value == 0) {
        document.getElementById('nombre_doctor').disabled = true;
        document.getElementById('nombre_doctor').value = "";

      } else {
        document.getElementById('nombre_doctor').disabled = false;
        document.getElementById('nombre_doctor').value = "";

        while (lista_doc.hasChildNodes()) {
          lista_doc.removeChild(lista_doc.firstChild);
        }

        turno = this.value;
      }

    });

    function confirmar() {

      if ($("#nombre_doctor").val() == "" || $("#nombre_paciente").val() == "" || $("#fecha_cita") == "" || $("#hora_cita") == "")
      {

        document.getElementById('alerta').style.display="";

      } else if ($("#fecha_cita").val().length > 10 || $("#hora_cita").val().length < 5) {

        document.getElementById('alerta_2').style.display="";

      } else {

        document.getElementById('registrar_cita').submit();

      }

    }

  </script>
</body>
</html>
