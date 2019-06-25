<?php

	session_start();
	require 'controladores/conexion.php';

	$sql = "SELECT * FROM trabajadores WHERE id_trabajadores = '".$_SESSION['id']."';";
	$con = mysqli_query($conexion, $sql) or die ('No se lograron consultar tus datos: '.mysqli_error($conexion));
	$datos = mysqli_fetch_assoc($con);

	switch ($datos['sexo_tra']) {
		case '1':
			$sexo = "Masculino";
			break;

		case '2':
			$sexo = "Femenino";
			break;
		
		default:
			$sexo = "No definido";
			break;
	}

	switch ($datos['turno_tra']) {
		case '1':
			$turno = "Mañana";
			break;

		case '2':
			$turno = "Tarde";
			break;
		
		default:
			$turno = "No definido";
			break;
	}

	switch ($datos['nivel_tra']) {
		case '1':
			$nivel = "Administrador";
			break;

		case '2':
			$nivel = "Secretario/a";
			break;

		case '3':
			$nivel = "Doctor/a";
			break;
		
		default:
			$nivel = "No definido";
			break;
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>IVSS José Antonio Vargas - Configuracion</title>
  	<link rel="shortcut icon" type="image/png" href="img/logo_ivss.png">

  	<!-- Bootstrap 4.3 -->
  	<link rel="stylesheet" href="css/bootstrap.min.css">
  	<script src="js/jquery3.3.1.js" charset="utf-8"></script>
  	<script src="js/bootstrap.min.js" charset="utf-8"></script>

  	<!-- Font Awesome -->
  	<link rel="stylesheet" href="css/all.css">
  	<script src="js/all.js" charset="utf-8"></script>

  	<!-- CSS -->
  	<link rel="stylesheet" href="css/estilos.css">
</head>
<body>

	<?php include 'plantillas/menu.php'; ?>

	<div class="container col-md-8 center-block formulario">
		<form action="">

			<div class="form-row">
				<div class="form-group col-md-4">
					<label for="cedula_tra">Cédula</label>
					<input type="text" id="cedula_tra" name="cedula_tra" class="form-control readonly" value="<?php echo $datos['cedula_tra']; ?>" readonly>
				</div>
				<div class="form-group col-md-4">
					<label for="nombre_tra">Nombre</label>
					<input type="text" id="nombre_tra" name="nombre_tra" class="form-control readonly" value="<?php echo $datos['nombre_tra']; ?>" readonly>
				</div>
				<div class="form-group col-md-4">
					<label for="apellido_tra">Apellido</label>
					<input type="text" id="apellido_tra" name="apellido_tra" class="form-control readonly" value="<?php echo $datos['apellido_tra']; ?>" readonly>
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-md-4">
					<label for="correo_tra">Correo</label>
					<input type="text" id="correo_tra" name="correo_tra" class="form-control readonly" value="<?php echo $datos['correo_tra']; ?>" readonly>
				</div>
				<div class="form-group col-md-4">
					<label for="celular_tra">Celular</label>
					<input type="text" id="celular_tra" name="celular_tra" class="form-control readonly" value="<?php echo $datos['celular_tra']; ?>" readonly>
				</div>
				<div class="form-group col-md-4">
					<label for="telefono_tra">Teléfono</label>
					<input type="text" id="telefono_tra" name="telefono_tra" class="form-control readonly" value="<?php echo $datos['telefono_tra']; ?>" readonly>
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-md-4">
					<label for="sexo_tra">Sexo</label>
					<input type="text" id="sexo_tra" name="sexo_tra" class="form-control readonly" value="<?php echo $sexo; ?>" readonly>
				</div>
				<div class="form-group col-md-4">
					<label for="edad_tra">Edad</label>
					<input type="text" id="edad_tra" name="edad_tra" class="form-control readonly" value="<?php echo $datos['edad_tra']; ?>" readonly>
				</div>
				<div class="form-group col-md-4">
					<label for="especialidad_tra">Especialidad</label>
					<input type="text" id="especialidad_tra" name="especialidad_tra" class="form-control readonly" value="<?php echo $datos['especialidad_tra']; ?>" readonly>
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-md-4">
					<label for="direccion_tra">Dirección</label>
					<textarea name="direccion_tra" id="direccion_tra" class="form-control readonly" cols="20" rows="3" readonly><?php echo $datos['direccion_tra']; ?></textarea>
				</div>
				<div class="form-group col-md-4">
					<label for="turno_tra">Turno</label>
					<input type="text" id="turno_tra" name="turno_tra" class="form-control readonly" value="<?php echo $turno; ?>" readonly>
				</div>
				<div class="form-group col-md-4">
					<label for="nivel_tra">Nivel</label>
					<input type="text" id="nivel_tra" name="nivel_tra" class="form-control readonly" value="<?php echo $nivel; ?>" readonly>
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="nueva_pass">Nueva Contraseña</label>
					<input type="password" id="nueva_pass" name="nueva_pass" class="form-control readonly" value="" readonly>
				</div>
				<div class="form-group col-md-6">
					<label for="repetir_pass">Repetir Contraseña</label>
					<input type="password" id="repetir_pass" name="repetir_pass" class="form-control readonly" value="" readonly>
				</div>
			</div>

				<button type="button" id="btn-edicion" class="btn btn-primary" onclick="accion()">Editar</button>
				<button type="button" id="btn-guardar" class="btn btn-success" onclick="guardar()" style="display: none;">Guardar</button>

		</form>
	</div>

	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

	<script>

		var edit = 1;

		const accion = async () => {

			if (edit == 1) {
				await edicion()
				edit = 2
			} else if (edit == 2) {
				await cancelar()
				edit = 1
			}

		}


		const edicion = () => {

			document.querySelector('#nueva_pass').removeAttribute('readonly')
			document.querySelector('#repetir_pass').removeAttribute('readonly')

			let boton = document.querySelector('#btn-edicion')

			boton.innerHTML = "Cancelar"
			boton.classList.remove('btn-primary')
			boton.classList.add('btn-danger')

			document.querySelector('#btn-guardar').style.display = ""
		}


		const cancelar = () => {

			let clave = document.querySelector('#nueva_pass')
			let rclave = document.querySelector('#repetir_pass')

			clave.setAttribute('readonly', '')
			rclave.setAttribute('readonly', '')

			clave.value = ""
			rclave.value = ""

			let boton = document.querySelector('#btn-edicion')

			boton.innerHTML = "Editar"
			boton.classList.remove('btn-danger')
			boton.classList.add('btn-primary')

			document.querySelector('#btn-guardar').style.display = "none"
		}


		const guardar = () => {

			let clave = document.querySelector('#nueva_pass')
			let rClave = document.querySelector('#repetir_pass')

			if (clave.value.trim() == "" || rClave.value.trim() == "") {

				swal({
					title:'Campos vacíos',
					icon:'error',
					button:'Entendido'
				})

			} else if (clave.value != rClave.value) {

				swal({
					title:'Las claves no son parecidas',
					icon:'warning',
					button:'Entendido'
				})

				clave.classList.add('is-invalid')
				rClave.classList.add('is-invalid')

			} else {

				clave.classList.remove('is-invalid')
				rClave.classList.remove('is-invalid')

				let new_data = new FormData();
				new_data.append('busqueda', 'perfil');
				new_data.append('clave', clave.value);
				new_data.append('rclave', rClave.value);

				fetch('manejadores/manejador_trabajadores.php', {
					method: 'POST',
					body: new_data
				})
				.then(res => res.json())
				.then(function(data){
					console.log(data)

					if (data == 1) {

						swal({
							title:'Las claves son diferentes',
							icon:'error',
							button:'Entendido'
						});

					} else if (data == 2) {

						swal({
							title:'Clave actualizada',
							icon:'success',
							button:'Ok'
						})

					}

				});

			}

		}

	</script>

</body>
</html>