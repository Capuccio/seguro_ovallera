<?php

session_start();

class pacientes
{

  function registrar($nombre, $apellido, $cedula, $correo, $celular, $telefono, $sexo, $edad, $direccion)
  {
    require 'conexion.php';
    date_default_timezone_set('America/Caracas');

    $registrar_sql = "INSERT INTO pacientes (nombre_pac, apellido_pac, cedula_pac, correo_pac, celular_pac, telefono_pac, direccion_pac, sexo_pac, edad_pac) VALUES ('".$nombre."', '".$apellido."', '".$cedula."', '".$correo."', '".$celular."', '".$telefono."', '".$direccion."', '".$sexo."', '".$edad."');";
    mysqli_query($conexion, $registrar_sql) or die('No se logró registrar al paciente: '.mysqli_error($conexion));

    $fecha = date("d/m/Y");
    $hora = date("H:i");
    $accion = "Registró al paciente ".$nombre;

    $audi_sql = "INSERT INTO auditoria (id_trabajadores, accion_aud, fecha_aud, hora_aud) VALUES ('".$_SESSION['id']."', '".$accion."', '".$fecha."', '".$hora."');";
    mysqli_query($conexion, $audi_sql) or die('No se logró registrar la auditoria: '.mysqli_error($conexion));

    return '1';

  }

}

?>
