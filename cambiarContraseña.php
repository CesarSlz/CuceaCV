<?php
	include('conectar.php');
  
	session_start();

	if (isset($_POST['cambiarContraAlumno'])) {
		$alumno = $_SESSION["alumno"];
		$contraActual = mysqli_real_escape_string($mysqli, $_POST['contraActual']);
		$contraNueva = mysqli_real_escape_string($mysqli, $_POST['contraNueva']);
		$contraConfirm = mysqli_real_escape_string($mysqli, $_POST['contraConfirm']);
					
		if($contraActual != $alumno['contraseña']) {
			$_SESSION['mensaje_error'] = "La contraseña actual no coincide";
			header('Location: contraseñaAlumno.php');
		}else {
			if($contraNueva != $contraConfirm) {
				$_SESSION['mensaje_error'] = "La nueva contraseña no coincide con la confirmación";
				header('Location: contraseñaAlumno.php');
			}else {
				$sql = "UPDATE alumnos SET contraseña = '$contraNueva' WHERE id = '". $alumno['id'] . "'";
						
				if (mysqli_query($mysqli, $sql)){
					
					$_SESSION['alumno']['contraseña'] = $contraNueva;

					$_SESSION['mensaje_exito'] = "Exito en modificar la contraseña";
					header('Location: perfilAlumno.php');
						
				}else {
					$_SESSION['mensaje_error'] = "Error al modificar la contraseña";
					header('Location: contraseñaAlumno.php');
				}
			}
		}
	}
	
	if (isset($_POST['cambiarContraProfesor'])) {
		$profesor = $_SESSION["profesor"];
		$contraActual = mysqli_real_escape_string($mysqli, $_POST['contraActual']);
		$contraNueva = mysqli_real_escape_string($mysqli, $_POST['contraNueva']);
		$contraConfirm = mysqli_real_escape_string($mysqli, $_POST['contraConfirm']);
					
		if($contraActual != $profesor['contraseña']) {
			$_SESSION['mensaje_error'] = "La contraseña actual no coincide";
			header('Location: contraseñaProfesor.php');
		}else {
			if($contraNueva != $contraConfirm) {
				$_SESSION['mensaje_error'] = "La nueva contraseña no coincide con la confirmación";
				header('Location: contraseñaProfesor.php');
			}else {
				$sql = "UPDATE profesores SET contraseña = '$contraNueva' WHERE id = '". $profesor['id'] . "'";
						
				if (mysqli_query($mysqli, $sql)){
					
					$_SESSION['profesor']['contraseña'] = $contraNueva;

					$_SESSION['mensaje_exito'] = "Exito en modificar la contraseña";
					header('Location: perfilProfesor.php');
						
				}else {
					$_SESSION['mensaje_error'] = "Error al modificar la contraseña";
					header('Location: contraseñaProfesor.php');
				}
			}
		}
	}
	?>