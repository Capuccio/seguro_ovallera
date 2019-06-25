<?php

$servidor = "localhost";
$usuario = "root";
$clave = "";
$base_datos = "seguro_ovallera";

$conexion = mysqli_connect($servidor, $usuario, $clave, $base_datos) or die ("Error al conectar con la base de datos: " . mysqli_error());

?>
