<?php
session_start();

class trabajadores {

  function login($correo, $contra)
  {
    require 'conexion.php';
    date_default_timezone_set('America/Caracas');

    $clv = substr(hash('sha512', $contra), 1, 15);

    $login_sql = "SELECT * FROM trabajadores WHERE correo_tra = '".$correo."' AND clave_tra = '".$clv."';";
    $login_con = mysqli_query($conexion, $login_sql) or die ("No se logró consultar el login: ".mysqli_error($conexion));
    $login = mysqli_fetch_assoc($login_con);

    if ($login) {

      $_SESSION['id'] = $login['id_trabajadores'];
      $_SESSION['nombre'] = $login['nombre_tra'];
      $_SESSION['cedula'] = $login['cedula_tra'];
      $_SESSION['nivel'] = $login['nivel_tra'];
      $fecha = date("d/m/Y");
      $hora = date("H:i");

      $audi_sql = "INSERT INTO auditoria (id_trabajadores, accion_aud, fecha_aud, hora_aud) VALUES ('".$_SESSION['id']."', 'Inicio de Sesion', '".$fecha."', '".$hora."');";
      mysqli_query($conexion, $audi_sql) or die('No se logró registrar la auditoria: '.mysqli_error($conexion));

      return '1';
    } else {
      return '2';
    }

  }

  function registrar_doctor($nombre, $apellido, $cedula, $correo, $celular, $telefono, $sexo, $edad, $turno, $especialidad, $direccion)
  {
    require 'conexion.php';
    date_default_timezone_set('America/Caracas');

    $registro_sql = "INSERT INTO trabajadores (nombre_tra, apellido_tra, cedula_tra, correo_tra, clave_tra, celular_tra, telefono_tra, direccion_tra, sexo_tra, edad_tra, especialidad_tra, turno_tra, nivel_tra) VALUES ('".$nombre."', '".$apellido."', '".$cedula."', '".$correo."', '0af4e2a428d75aa', '".$celular."', '".$telefono."', '".$direccion."', '".$sexo."', '".$edad."', '".$especialidad."', '".$turno."', '3');";
    mysqli_query($conexion, $registro_sql) or die('No se logró registrar el doctor: '.mysqli_error($conexion));

    $fecha = date("d/m/Y");
    $hora = date("H:i");
    $accion = "Registró al doctor ".$nombre;

    $audi_sql = "INSERT INTO auditoria (id_trabajadores, accion_aud, fecha_aud, hora_aud) VALUES ('".$_SESSION['id']."', '".$accion."', '".$fecha."', '".$hora."');";
    mysqli_query($conexion, $audi_sql) or die('No se logró registrar la auditoria: '.mysqli_error($conexion));

    return '1';
  }

  function registrar_secretario($nombre, $apellido, $cedula, $correo, $celular, $telefono, $sexo, $edad, $turno, $direccion)
  {
    require 'conexion.php';
    date_default_timezone_set('America/Caracas');

    $registro_sql = "INSERT INTO trabajadores (nombre_tra, apellido_tra, cedula_tra, correo_tra, clave_tra, celular_tra, telefono_tra, direccion_tra, sexo_tra, edad_tra, especialidad_tra, turno_tra, nivel_tra) VALUES ('".$nombre."', '".$apellido."', '".$cedula."', '".$correo."', '97bb2eaab5d0276', '".$celular."', '".$telefono."', '".$direccion."', '".$sexo."', '".$edad."', 'Secretario', '".$turno."', '2');";
    mysqli_query($conexion, $registro_sql) or die ('No se logró registrar el/la secretario/a: '.mysqli_error($conexion));

    $fecha = date("d/m/Y");
    $hora = date("H:i");
    $accion = "Registró al secretario ".$nombre;

    $audi_sql = "INSERT INTO auditoria (id_trabajadores, accion_aud, fecha_aud, hora_aud) VALUES ('".$_SESSION['id']."', '".$accion."', '".$fecha."', '".$hora."');";
    mysqli_query($conexion, $audi_sql) or die('No se logró registrar la auditoria: '.mysqli_error($conexion));

    return '1';
  }

  function registrar_cita($doctor, $paciente, $fecha, $hora)
  {
    require 'conexion.php';
    date_default_timezone_set('America/Caracas');

    $sql_tra = "SELECT * FROM trabajadores WHERE cedula_tra = '".$doctor."';";
    $con_tra = mysqli_query($conexion, $sql_tra) or die('No se logró consultar trabajador: '.mysqli_error($conexion));
    $id_tra = mysqli_fetch_assoc($con_tra);

    if (empty($id_tra)) {
      return '1';
    }

    $sql_pac = "SELECT * FROM pacientes WHERE cedula_pac = '".$paciente."';";
    $con_pac = mysqli_query($conexion, $sql_pac) or die('No se logró consultar paciente: '.mysqli_error($conexion));
    $id_pac = mysqli_fetch_assoc($con_pac);

    if (empty($id_pac)) {
      return '2';
    }

    $sql_cita = "INSERT INTO citas (id_trabajadores, id_pacientes, fecha_cit, hora_cit, status_cit) VALUES ('".$id_tra['id_trabajadores']."', '".$id_pac['id_pacientes']."', '".$fecha."', '".$hora."', '1');";
    mysqli_query($conexion, $sql_cita) or die ('No se logró registrar la cita: '.mysqli_error($conexion));


    $fecha = date("d/m/Y");
    $hora = date("H:i");
    $accion = "Registró una Cita para el doctor ".$id_tra['nombre_tra']." con el paciente ".$id_pac['nombre_pac'];

    $audi_sql = "INSERT INTO auditoria (id_trabajadores, accion_aud, fecha_aud, hora_aud) VALUES ('".$_SESSION['id']."', '".$accion."', '".$fecha."', '".$hora."');";
    mysqli_query($conexion, $audi_sql) or die('No se logró registrar la auditoria: '.mysqli_error($conexion));

    return '3';
  }

  function finalizada_cita($motivo, $respuesta, $primer_insumo, $uno_insumo, $segundo_insumo, $dos_insumo, $tercer_insumo, $tres_insumo, $cita)
  {
    require 'conexion.php';

    $sql = "UPDATE citas SET motivo_cit = '".$motivo."', respuesta_cit = '".$respuesta."', status_cit = '2' WHERE id_citas = '".$cita."';";
    mysqli_query($conexion, $sql) or die('No se logró actualizar la cita');

    if ($primer_insumo != 0) {

      $sql_i = "SELECT * FROM insumos WHERE id_insumos = '".$primer_insumo."';";
      $db = mysqli_query($conexion, $sql_i) or die ('No se logró consultar el insumo: '.mysqli_error($conexion));
      $insumo = mysqli_fetch_assoc($db);

      $nueva_cantidad = $insumo['cantidad_ins'] - $uno_insumo;

      $sql_1 = "UPDATE insumos SET cantidad_ins = '".$nueva_cantidad."' WHERE id_insumos = '".$primer_insumo."';";
      mysqli_query($conexion, $sql_1) or die ('No se logró actualizar el primer insumo');

    }

    if ($segundo_insumo != 0) {

      $sql_in = "SELECT * FROM insumos WHERE id_insumos = '".$segundo_insumo."';";
      $bd = mysqli_query($conexion, $sql_in) or die ('No se logró consultar el insumo: '.mysqli_error($conexion));
      $insumos = mysqli_fetch_assoc($bd);

      $nueva_cantidad = $insumos['cantidad_ins'] - $dos_insumo;

      $sql_2 = "UPDATE insumos SET cantidad_ins = '".$nueva_cantidad."' WHERE id_insumos = '".$segundo_insumo."';";
      mysqli_query($conexion, $sql_2) or die ('No se logró actualizar el primer insumo');

    }

    if ($tercer_insumo != 0) {

      $sql_ins = "SELECT * FROM insumos WHERE id_insumos = '".$tercer_insumo."';";
      $dbz = mysqli_query($conexion, $sql_ins) or die ('No se logró consultar el insumo: '.mysqli_error($conexion));
      $insumos = mysqli_fetch_assoc($dbz);

      $nueva_cantidad = $insumos['cantidad_ins'] - $tres_insumo;

      $sql_3 = "UPDATE insumos SET cantidad_ins = '".$nueva_cantidad."' WHERE id_insumos = '".$tercer_insumo."';";
      mysqli_query($conexion, $sql_3) or die ('No se logró actualizar el primer insumo');

    }
    

    return '1';
  }

  function registrar_insumos($nombre, $cantidad, $fecha)
  {
    require 'conexion.php';
    date_default_timezone_set('America/Caracas');

    $insumos_sql = "INSERT INTO insumos (nombre_ins, cantidad_ins, fecha_vencimiento_ins) VALUES ('".$nombre."', '".$cantidad."', '".$fecha."');";
    mysqli_query($conexion, $insumos_sql) or di('No se logró registrar el insumo: '.mysqli_error($conexion));

    $fecha = date("d/m/Y");
    $hora = date("H:i");
    $accion = "Registró un nuevo insumo: ".$nombre;

    $audi_sql = "INSERT INTO auditoria (id_trabajadores, accion_aud, fecha_aud, hora_aud) VALUES ('".$_SESSION['id']."', '".$accion."', '".$fecha."', '".$hora."');";
    mysqli_query($conexion, $audi_sql) or die('No se logró registrar la auditoria: '.mysqli_error($conexion));

    return '1';

  }

}

?>
