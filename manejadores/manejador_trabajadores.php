<?php

  session_start();
  require '../controladores/conexion.php';
  $ajax = $_POST['busqueda'];

  switch ($ajax) {
    case 'cedula':

      if (is_numeric($_POST['cedula'])) {

        $sql_ced = "SELECT cedula_tra FROM trabajadores WHERE cedula_tra = '".$_POST['cedula']."';";
        $sql_con = mysqli_query($conexion, $sql_ced) or die('No se logró realizar la consulta: '.mysqli_error($conexion));
        $cedula = mysqli_fetch_assoc($sql_con);

        if (empty($cedula['cedula_tra'])) {
          echo "1";
        } else {
          echo "2";
        }

      } else {
        echo "3";
      }

      break;

    case 'correo':

      $sql_cor = "SELECT correo_tra FROM trabajadores WHERE correo_tra = '".$_POST['correo']."';";
      $sql_con = mysqli_query($conexion, $sql_cor) or die("No se logró la consulta: ".mysqli_error($conexion));
      $correo = mysqli_fetch_assoc($sql_con);

      if (empty($correo['correo_tra'])) {
        echo "1";
      } else {
        echo "2";
      }

      break;

    case 'trabajador':

      $sql_tra = "SELECT * FROM trabajadores WHERE nombre_tra LIKE '%".$_POST['nombre']."%' AND nivel_tra = '3' AND turno_tra = '".$_POST['turno']."';";
      $con_tra = mysqli_query($conexion, $sql_tra) or die ('No se logró consultar trabla: '.mysqli_error($conexion));
      $trabajadores = array();

      while ($datos = mysqli_fetch_assoc($con_tra)) {
        $trabajadores['Trabajadores'][] = $datos;
      }

      echo json_encode($trabajadores);

      break;

    case 'insumo':

      $sql_ins = "SELECT nombre_ins FROM insumos WHERE nombre_ins = '".$_POST['nombre']."';";
      $con_ins = mysqli_query($conexion, $sql_ins) or die ('No se logró consultar el insumo: '.mysqli_error($conexion));
      $insumo_name = mysqli_fetch_assoc($con_ins);

      if (empty($insumo_name)) {
        echo '1';
      } else {
        echo '2';
      }

      break;

    case 'perfil':

        if ($_POST['clave'] != $_POST['rclave']) {
          echo $res['Respuesta'][0] = 1;
        } else {

          $clave = substr(hash('sha512', $_POST['clave']), 1, 15);

          $sql = "UPDATE trabajadores SET clave_tra = '".$clave."' WHERE id_trabajadores = '".$_SESSION['id']."';";

          mysqli_query($conexion, $sql) or die('No se logró actualizar la clave: '.mysqli_error($conexion));

          echo $res['Respuesta'][0] = 2;

        }

      break;

    case 'insumos':

      $sql = "SELECT * FROM insumos;";
      $con_insu = mysqli_query($conexion, $sql) or die ('No se logró consultar la tabla insumos: '.mysqli_error($conexion));
      $insumos = array();

      while ($datos = mysqli_fetch_assoc($con_insu)) {
        $insumos['Insumos'][] = $datos;
      }

      echo json_encode($insumos);

      break;

    default:
      // code...
      break;
  }

?>
