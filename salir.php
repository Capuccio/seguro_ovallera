<?php
  date_default_timezone_set('America/Caracas');
  require 'controladores/conexion.php';

  session_start();

  $fecha = date("d/m/Y");
  $hora = date("H:i");
  $accion = "Se desconecto";

  $audi_sql = "INSERT INTO auditoria (id_trabajadores, accion_aud, fecha_aud, hora_aud) VALUES ('".$_SESSION['id']."', '".$accion."', '".$fecha."', '".$hora."');";
  mysqli_query($conexion, $audi_sql) or die('No se logró registrar la auditoria: '.mysqli_error($conexion));

  $_SESSION = array();
  session_destroy();

  header('Location: index.php');
?>
