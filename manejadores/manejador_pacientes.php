<?php

  require '../controladores/conexion.php';
  $ajax = $_POST['busqueda'];

  switch ($ajax) {
    case 'cedula':

    if (is_numeric($_POST['cedula'])) {

      $sql_ced = "SELECT cedula_pac FROM pacientes WHERE cedula_pac = '".$_POST['cedula']."';";
      $sql_con = mysqli_query($conexion, $sql_ced) or die('No se logró realizar la consulta: '.mysqli_error($conexion));
      $cedula = mysqli_fetch_assoc($sql_con);

      if (empty($cedula['cedula_pac'])) {
        echo "1";
      } else {
        echo "2";
      }

    } else {
      echo "3";
    }

      break;

    case 'correo':

      $sql_cor = "SELECT correo_pac FROM pacientes WHERE correo_pac = '".$_POST['correo']."';";
      $sql_con = mysqli_query($conexion, $sql_cor) or die("No se logró la consulta: ".mysqli_error($conexion));
      $correo = mysqli_fetch_assoc($sql_con);

      if (empty($correo['correo_pac'])) {
        echo "1";
      } else {
        echo "2";
      }

      break;

    case 'paciente':

      $sql_pac = "SELECT * FROM pacientes WHERE nombre_pac LIKE '%".$_POST['nombre']."%';";
      $con_pac = mysqli_query($conexion, $sql_pac) or die('No se logró consultar la tabla pacientes: '.mysqli_error($conexion));
      $datos = array();

      while ($pacientes = mysqli_fetch_assoc($con_pac)) {
        $datos['Pacientes'][] = $pacientes;
      }

      echo json_encode($datos);

      break;

    default:
      // code...
      break;
  }

?>
