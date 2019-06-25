<?php

	session_start();
	require 'controladores/conexion.php';
	date_default_timezone_set('America/Caracas');
	$fecha = date("Y-m");

	$sql_citas = "SELECT COUNT(id_citas) as total_citas FROM citas WHERE fecha_cit LIKE '%".$fecha."%';";
	$con_citas = mysqli_query($conexion, $sql_citas) or die ('No se logró consultar las citas: '.mysqli_error($conexion));
	$citas = mysqli_fetch_assoc($con_citas);

	$sql_trabajadores = "SELECT COUNT(id_trabajadores) as total_trabajadores FROM trabajadores;";
	$con_trabajadores = mysqli_query($conexion, $sql_trabajadores) or die ('No se logró consultar los trabajadores: '.mysqli_error($conexion));
	$trabajadores = mysqli_fetch_assoc($con_trabajadores);

	$sql_pacientes = "SELECT COUNT(id_pacientes) as total_pacientes FROM pacientes;";
	$con_pacientes = mysqli_query($conexion, $sql_pacientes) or die ('No se logró consultar los pacientes: '.mysqli_error($conexion));
	$pacientes = mysqli_fetch_assoc($con_pacientes);

	$sql_insumos = "SELECT COUNT(id_insumos) as total_insumos FROM insumos;";
	$con_insumos = mysqli_query($conexion, $sql_insumos) or die ('No se logró consultar los insumos: '.mysqli_error($conexion));
	$insumos = mysqli_fetch_assoc($con_insumos);

	if ($_SESSION['nivel'] != 1 && $_SESSION['nivel'] != 2) {
		header('Location: inicio.php');
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Gráfica</title>
	 <link rel="shortcut icon" type="image/png" href="img/logo_ivss.png">
	 <!-- Bootstrap 4.3 -->
	 <link rel="stylesheet" href="css/bootstrap.min.css">
	 <script src="https://code.jquery.com/jquery-3.4.0.min.js" charset="utf-8"></script>
	 <script src="js/bootstrap.min.js" charset="utf-8"></script>

	 <!-- Font Awesome -->
	 <link rel="stylesheet" href="css/all.css">
	 <script src="js/all.js" charset="utf-8"></script>

	<!-- ChartJS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js"></script>

	 <!-- CSS -->
	 <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

	<?php require 'plantillas/menu.php'; ?>

	<div class="contenido">
		<canvas id="myChart" width="400" height="400"></canvas>
	</div>

<script>
var ctx = document.getElementById('myChart').getContext('2d');
var citas = "<?php echo $citas['total_citas']; ?>"
var trabajadores = "<?php echo $trabajadores['total_trabajadores']; ?>"
var pacientes = "<?php echo $pacientes['total_pacientes']; ?>"
var insumos = "<?php echo $insumos['total_insumos']; ?>"
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Citas del Mes', 'Empleados', 'Pacientes', 'Insumos'],
        datasets: [{
            label: 'Estadísticas',
            data: [citas, trabajadores, pacientes, insumos],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
</script>

</body>
</html>