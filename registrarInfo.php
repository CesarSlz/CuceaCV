<?php
	include('conectar.php');
  
	session_start();
	
	//Registro de alumno	
	if (isset($_POST['rAlumno'])) {
		$codigo= mysqli_real_escape_string($mysqli, $_POST['codigo']);
		$nombre= mysqli_real_escape_string($mysqli, $_POST["nombre"]);
		$apellido_pat = mysqli_real_escape_string($mysqli, $_POST['apellidoPat']);
		$apellido_mat = mysqli_real_escape_string($mysqli, $_POST['apellidoMat']);
		$maestria = mysqli_real_escape_string($mysqli, $_POST['maestria']);	
		$contraseña = mysqli_real_escape_string($mysqli, $_POST['contraseña']);		
		$cicloIngreso = mysqli_real_escape_string($mysqli, $_POST['cicloIngreso']);		
		
		$sql = "INSERT INTO alumnos (id_posgrado, codigo, nombre, apellido_pat, apellido_mat, contraseña, ciclo_ingreso)
				VALUES('$maestria', '$codigo','$nombre','$apellido_pat','$apellido_mat','$contraseña', '$cicloIngreso')";
		
		if (mysqli_query($mysqli, $sql)){
			$_SESSION['mensaje_exito'] = "Exito al registrar el nuevo Alumno";
			header('Location: registrarAlumno.php');
		}else {
			$_SESSION['mensaje_error'] = "Error al registrar el nuevo Alumno";
			header('Location: registrarAlumno.php');
		}
	}
	
	//Registro de profesor	
	if (isset($_POST['rProfesor'])) {
		$codigo= mysqli_real_escape_string($mysqli, $_POST['codigo']);
		$nombre= mysqli_real_escape_string($mysqli, $_POST["nombre"]);
		$apellido_pat = mysqli_real_escape_string($mysqli, $_POST['apellidoPat']);
		$apellido_mat = mysqli_real_escape_string($mysqli, $_POST['apellidoMat']);
		$contraseña = mysqli_real_escape_string($mysqli, $_POST['contraseña']);		
		
		$sql = "INSERT INTO profesores (codigo, nombre, apellido_pat, apellido_mat, contraseña)
				VALUES('$codigo','$nombre','$apellido_pat','$apellido_mat','$contraseña')";
		
		if (mysqli_query($mysqli, $sql)){
			$_SESSION['mensaje_exito'] = "Exito al registrar el nuevo Profesor";
			header('Location: registrarProfesor.php');
		}else {
			$_SESSION['mensaje_error'] = "Error al registrar el nuevo Profesor";
			header('Location: registrarProfesor.php');
		}
	}
	
	//Registro de profesor	
	if (isset($_POST['rAdmin'])) {
		$usuario= mysqli_real_escape_string($mysqli, $_POST['usuario']);
		$contraseña = mysqli_real_escape_string($mysqli, $_POST['contraseña']);
		$coordinacion = mysqli_real_escape_string($mysqli, $_POST['coordinacion']);
		
		$sqlBusqueda = "SELECT usuario FROM usuarios WHERE usuario = '$usuario'";
		
		$result = mysqli_query($mysqli, $sqlBusqueda);
		if(mysqli_num_rows($result) > 0){
			$_SESSION['mensaje_error'] = "El nombre de usuario ya existe";
			header('Location: registrarAdmin.php');
		}else{
			$sql = "INSERT INTO usuarios (id_posgrado, usuario, contraseña)
				VALUES('$coordinacion', '$usuario', '$contraseña')";
		
			if (mysqli_query($mysqli, $sql)){
				$_SESSION['mensaje_exito'] = "Exito al registrar el nuevo Administrador";
				header('Location: registrarAdmin.php');
			}else {
				$_SESSION['mensaje_error'] = "Error al registrar el nuevo Administrador";
				header('Location: registrarAdmin.php');
			}
		}
	}
?>		