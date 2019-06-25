<?php 

	require 'controladores/conexion.php';
	require 'controladores/controlador_trabajadores.php';

	if ($_SESSION['nivel'] != 3) {
		header('Location: inicio.php');
	}

	if (isset($_POST['motivo'])) {

		$trabajadores = new trabajadores;
		$res = $trabajadores->finalizada_cita($_POST['motivo'], $_POST['recomendacion'], $_POST['select_uno'], $_POST['nro_uno'], $_POST['select_dos'], $_POST['nro_dos'], $_POST['select_tres'], $_POST['nro_tres'], $_POST['cita']);

		if ($res == 1) {
		
			header('Location: citas.php?cita_f=1');

		}

	}

	$sql = "SELECT * FROM insumos;";
	$con = mysqli_query($conexion, $sql) or die ('No se logró consultar los insumos: '.mysqli_error($conexion));

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>IVSS José Antonio Vargas - Cita</title>
  <link rel="shortcut icon" type="image/png" href="img/logo_ivss.png">
  <!-- Bootstrap 4.3 -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="js/jquery3.3.1.js"></script>
  <script src="js/bootstrap.min.js" charset="utf-8"></script>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="css/all.css">
  <script src="js/all.js" charset="utf-8"></script>

  <!-- CSS -->
  <link rel="stylesheet" href="css/estilos.css">

</head>
<body>
	<?php require 'plantillas/menu.php'; ?>

	<div class="formulario col-md-8 center-block container">

		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" id="formulario_cita" method="POST">
			
			<div class="form-row">
				<div class="form-group col">
					<label for="" class="h3">Motivo de la visita</label>
					<textarea name="motivo" id="motivo_visit" class="form-control" rows="5" placeholder="Motivo..."></textarea>
					<div class="invalid-feedback">
						No puede dejar este campo vacío
					</div>
				</div>
				<div class="col">
					<label for="" class="h3">Recomendación dada</label>
					<textarea name="recomendacion" id="recomendacion_visit" class="form-control" rows="5" placeholder="Recomendación..."></textarea>
					<div class="invalid-feedback">
						No puede dejar este campo vacío
					</div>
				</div>
			</div>

			<div class="form-row align-items-center">
				<div class="form-group">
					<div class="form-check col">
						<input class="form-check-input" type="checkbox" id="checkgastos">
						<label class="form-check-label" for="checkgastos">
							<p class="h6">Marcar si se utilizaron insumos</p>
			 			</label>
					</div>
				</div>
			</div>

				<div class="form-group" id="selects" style="display: none;">

					<div class="form-row">
						<div class="col">
							<select name="select_uno" class="custom-select" id="primero">
								<option value="0">Selecciona Insumo</option>
							</select>
						</div>
						<div class="col">
							<select name="select_dos" class="custom-select" id="segundo">
								<option value="0">Selecciona Insumo</option>
							</select>
						</div>
						<div class="col">
							<select name="select_tres" class="custom-select" id="tercero">
								<option value="0">Selecciona Insumo</option>
							</select>
						</div>
					</div>
				</div>

				<div class="form-group" id="numeros" style="display: none;">

					<div class="form-row">
						<div class="col">
							<input type="number" class="form-control disabled" id="pri" value="0" name="nro_uno">
							<div class="invalid-feedback">
								No puede dejar este campo sin número, debe agregar número a restar, si no gastó ninguno, dejarlo en 0
							</div>
						</div>
						<div class="col">
							<input type="number" class="form-control disabled" id="seg" value="0" name="nro_dos">
							<div class="invalid-feedback">
								No puede dejar este campo sin número, debe agregar número a restar, si no gastó ninguno, dejarlo en 0
							</div>
						</div>
						<div class="col">
							<input type="number" class="form-control disabled" id="ter" value="0" name="nro_tres">
							<div class="invalid-feedback">
								No puede dejar este campo sin número, debe agregar número a restar, si no gastó ninguno, dejarlo en 0
							</div>
						</div>
					</div>

				</div>

				<input type="hidden" name="cita" value="<?php echo $_GET['cita'] ?>">

				<button type="button" class="btn btn-success" onclick="enviarForm()">Cita Terminada</button>

		</form>

	</div>

	<script>

		document.getElementById('checkgastos').addEventListener('click', function() {

			if (this.checked) {

				document.getElementById('selects').style.display="";
				document.getElementById('numeros').style.display="";

			} else {

				document.getElementById('selects').style.display="none";
				document.getElementById('numeros').style.display="none";

			}

		});

		const loadDatos = () => {

			let datos = new FormData();
			datos.append('busqueda', 'insumos');

			fetch('manejadores/manejador_trabajadores.php', {
				method: 'POST',
				body: datos
			})
			.then(res => res.json())
			.then(function(insumos){

				for (var v = 0; v < 3; v++) {

					if (v == 0) { var select = document.getElementById('primero') }
					if (v == 1) { var select = document.getElementById('segundo') }
					if (v == 2) { var select = document.getElementById('tercero') }

						for (var i = 0; i < insumos.Insumos.length; i++) {

							var opcion = document.createElement('option');
							opcion.value = insumos.Insumos[i].id_insumos;
							opcion.innerHTML = insumos.Insumos[i].nombre_ins;
							select.appendChild(opcion);

						}

				}

			})
			.catch(err => console.log(err))

		}

		document.getElementById('primero').addEventListener('change', function() {

			var input = document.getElementById('pri')

			if (this.value == 0) {

				input.value = "0"

			} else {

				input.disabled = ""

			}

		})

		document.getElementById('segundo').addEventListener('change', function() {

			var input = document.getElementById('seg')

			if (this.value == 0) {

				input.value = "0"

			} else {

				input.disabled = ""

			}

		})

		document.getElementById('tercero').addEventListener('change', function() {

			var input = document.getElementById('ter')

			if (this.value == 0) {

				input.value = "0"

			} else {

				input.disabled = ""

			}

		})

		const enviarForm = () => {

			let motivo = document.getElementById('motivo_visit')
			let recomendacion = document.getElementById('recomendacion_visit')
			let pri = document.getElementById('pri')
			let seg = document.getElementById('seg')
			let ter = document.getElementById('ter')

			if (motivo.value.trim() == "" || recomendacion.value.trim() == "") {

				motivo.classList.add('is-invalid')
				recomendacion.classList.add('is-invalid')

			} else if (pri.value.trim() == "" || seg.value.trim() == "" || ter.value.trim() == "") {

				motivo.classList.remove('is-invalid')
				recomendacion.classList.remove('is-invalid')

				if (pri.value.trim() == "") return pri.classList.add('is-invalid')
				if (seg.value.trim() == "") return seg.classList.add('is-invalid')
				if (ter.value.trim() == "") return ter.classList.add('is-invalid')

			} else {

				document.getElementById('formulario_cita').submit()

			}

		}

		window.onload = loadDatos()

	</script>

</body>
</html>