<?php
	include('conectar.php');
  
	session_start();
	
	if (isset($_POST['actualizarRegistroAlumno'])) {
		$alumno = $_SESSION["alumno"];
		$correo  = mysqli_real_escape_string($mysqli, $_POST['correo']);
		$telefono = mysqli_real_escape_string($mysqli, $_POST['telefono']);
		$password = mysqli_real_escape_string($mysqli, $_POST['contraseña']);
		$genero = mysqli_real_escape_string($mysqli, $_POST['genero']);
		
		if($password != $_SESSION['alumno']['contraseña']){
			
			$sql = "UPDATE alumnos SET correo = '$correo', telefono = '$telefono', 
			contraseña = '$password', genero = '$genero' WHERE id = '" . $alumno['id'] . "'";
			
			if (mysqli_query($mysqli, $sql)){
				$_SESSION['alumno']['correo'] = $correo;
				$_SESSION['alumno']['telefono'] = $telefono;
				$_SESSION['alumno']['contraseña'] = $password;
				$_SESSION['alumno']['genero'] = $genero;
			
				$_SESSION['mensaje_exito'] = "Exito en actualizar los datos";
				header('Location: panelDelEstudiante.php');
						
			}else {
			$_SESSION['mensaje_error'] = "Error al actualizar los datos";
			header('Location: actualizarAlumno.php');
			}
			
		}else{
			$_SESSION['mensaje_error'] = "La nueva contraseña debe ser diferente a la actual";
			header('Location: actualizarAlumno.php');
		}
					
		
		
	}else if (isset($_POST['actualizarInfoAlumno'])) {
		$alumno = $_SESSION["alumno"];
		$correo  = mysqli_real_escape_string($mysqli, $_POST['correo']);
		$telefono = mysqli_real_escape_string($mysqli, $_POST['telefono']);
		$genero = mysqli_real_escape_string($mysqli, $_POST['genero']);
					
		$sql = "UPDATE alumnos SET correo = '$correo', telefono = '$telefono', 
			genero = '$genero' WHERE id = '". $alumno['id'] . "'";
						
		if (mysqli_query($mysqli, $sql)){
			$_SESSION['alumno']['correo'] = $correo;
			$_SESSION['alumno']['telefono'] = $telefono;
			$_SESSION['alumno']['genero'] = $genero;
			
			$_SESSION['mensaje_exito'] = "Exito en modificar los datos";
			header('Location: perfilAlumno.php');
						
		}else {
			$_SESSION['mensaje_error'] = "Error al modificar los datos";
			header('Location: perfilAlumno.php');
		}
	}
	
	if (isset($_POST['actualizarRegistroProfesor'])) {
		$profesor = $_SESSION["profesor"];
		$correo  = mysqli_real_escape_string($mysqli, $_POST['correo']);
		$telefono = mysqli_real_escape_string($mysqli, $_POST["telefono"]);
		$password = mysqli_real_escape_string($mysqli, $_POST["contraseña"]);
		$genero = mysqli_real_escape_string($mysqli, $_POST["genero"]);
		$biografia = mysqli_real_escape_string($mysqli, $_POST["biografia"]);
		
		foreach($_POST["areaInvestigacion"] as $key => $value) {
			$areaInvestigacion .= mysqli_real_escape_string($mysqli, $value) . "_";
		}
		
		foreach($_POST["publicaciones"] as $key => $value) {
			$publicaciones .= mysqli_real_escape_string($mysqli, $value) . "_";
		}
		
		$tesis = mysqli_real_escape_string($mysqli, $_POST["tesis"]);
		$resumen = mysqli_real_escape_string($mysqli, $_POST["resumen"]);
		$nombreImg = $_FILES['foto']['name'];
		$tipo = $_FILES['foto']['type'];
		$tamano = $_FILES['foto']['size'];
		
		if($password != $_SESSION['profesor']['contraseña']){
		
			if(($nombreImg != null) && ($_FILES['foto']['size'] <= 400000)){
				if(($_FILES['foto']['type'] == "image/png") || ($_FILES['foto']['type'] == "image/jpg") || ($_FILES['foto']['type'] == "image/jpeg")){
					$directorio = $_SERVER['DOCUMENT_ROOT'] . '/cuceacv/styles/img/profesores/';
					
					move_uploaded_file($_FILES['foto']['tmp_name'], $directorio.$nombreImg);
					
					$sql = "UPDATE profesores SET contraseña = '$password', correo = '$correo', telefono = '$telefono', biografia='$biografia', 
						area_investigacion='$areaInvestigacion', tesis='$tesis', resumen='$resumen', publicaciones='$publicaciones',
						genero = '$genero', foto = '$nombreImg' WHERE id = '" . $profesor['id'] . "'";
						
					if (mysqli_query($mysqli, $sql)){
						$_SESSION['profesor']['correo'] = $correo;
						$_SESSION['profesor']['telefono'] = $telefono;
						$_SESSION['profesor']['contraseña'] = $password;
						$_SESSION['profesor']['genero'] = $genero;
						$_SESSION['profesor']['biografia'] = $biografia;
						$_SESSION['profesor']['area_investigacion'] = $areaInvestigacion;
						$_SESSION['profesor']['tesis'] = $tesis;
						$_SESSION['profesor']['resumen'] = $resumen;
						$_SESSION['profesor']['publicaciones'] = $publicaciones;
						
						$_SESSION['mensaje_exito'] = "Exito en actualizar los datos";
						header('Location: panelDelProfesor.php');
					
					}else {
						$_SESSION['mensaje_error'] = "Error al actualizar los datos";
						header('Location: actualizarProfesor.php');
					}
				}else{
					$_SESSION['mensaje_error'] = "El formato de la fotografía no esta permitido";
					header('Location: actualizarProfesor.php');
				}
			}else{
				if($nombreImg != null){
					$_SESSION['mensaje_error'] = "La fotografía excede el tamaño permitido";
					header('Location: actualizarProfesor.php');
				}else{
					$_SESSION['mensaje_error'] = "Por favor sube tu foto de perfil";
					header('Location: actualizarProfesor.php');
				}
				
			}
		}else{
			$_SESSION['mensaje_error'] = "La nueva contraseña debe ser diferente a la actual";
			header('Location: actualizarProfesor.php');
		}
	}
	
	if (isset($_POST['actualizarInfoProfesor'])) {
		$profesor = $_SESSION["profesor"];
		$correo  = mysqli_real_escape_string($mysqli, $_POST['correo']);
		$telefono = mysqli_real_escape_string($mysqli, $_POST["telefono"]);
		$genero = mysqli_real_escape_string($mysqli, $_POST["genero"]);
		$biografia = mysqli_real_escape_string($mysqli, $_POST["biografia"]);
		
		foreach($_POST["areaInvestigacion"] as $key => $value) {
			$areaInvestigacion .= mysqli_real_escape_string($mysqli, $value) . "_";
		}
		
		foreach($_POST["publicaciones"] as $key => $value) {
			$publicaciones .= mysqli_real_escape_string($mysqli, $value) . "_";
		}
		
		$tesis = mysqli_real_escape_string($mysqli, $_POST["tesis"]);
		$resumen = mysqli_real_escape_string($mysqli, $_POST["resumen"]);
		
		$nombreImg = $_FILES['foto']['name'];
		$tipo = $_FILES['foto']['type'];
		$tamano = $_FILES['foto']['size'];
		
		if($nombreImg != null){
			if(($_FILES['foto']['size'] <= 400000)){
				if(($_FILES['foto']['type'] == "image/png") || ($_FILES['foto']['type'] == "image/jpg") || ($_FILES['foto']['type'] == "image/jpeg")){
					$directorio = $_SERVER['DOCUMENT_ROOT'] . '/cuceacv/styles/img/profesores/';
					
					move_uploaded_file($_FILES['foto']['tmp_name'], $directorio.$nombreImg);
					
					$sql = "UPDATE profesores SET correo = '$correo', telefono = '$telefono', biografia='$biografia', 
						area_investigacion='$areaInvestigacion', tesis='$tesis', resumen='$resumen', publicaciones='$publicaciones',
						genero = '$genero', foto = '$nombreImg' WHERE id = '" . $profesor['id'] . "'";
						
					if (mysqli_query($mysqli, $sql)){
						$_SESSION['profesor']['correo'] = $correo;
						$_SESSION['profesor']['telefono'] = $telefono;
						$_SESSION['profesor']['genero'] = $genero;
						$_SESSION['profesor']['biografia'] = $biografia;
						$_SESSION['profesor']['area_investigacion'] = $areaInvestigacion;
						$_SESSION['profesor']['tesis'] = $tesis;
						$_SESSION['profesor']['resumen'] = $resumen;
						$_SESSION['profesor']['publicaciones'] = $publicaciones;
						$_SESSION['profesor']['foto'] = $nombreImg;
						
						$_SESSION['mensaje_exito'] = "Exito en modificar los datos";
						header('Location: perfilProfesor.php');
					}else{
						$_SESSION['mensaje_error'] = "Error al modificar los datos";
						header('Location: perfilProfesor.php');
					}
				}else{
					$_SESSION['mensaje_error'] = "El formato de la fotografía no esta permitido";
					header('Location: perfilProfesor.php');
				}
			}else{
				$_SESSION['mensaje_error'] = "La fotografía excede el tamaño permitido";
				header('Location: perfilProfesor.php');
			}
		}else{
			
			$sql = "UPDATE profesores SET correo = '$correo', telefono = '$telefono', biografia='$biografia', 
				area_investigacion='$areaInvestigacion', tesis='$tesis', resumen='$resumen', publicaciones='$publicaciones',
				genero = '$genero' WHERE id = '" . $profesor['id'] . "'";
				
			if (mysqli_query($mysqli, $sql)){
				$_SESSION['profesor']['correo'] = $correo;
				$_SESSION['profesor']['telefono'] = $telefono;
				$_SESSION['profesor']['genero'] = $genero;
				$_SESSION['profesor']['biografia'] = $biografia;
				$_SESSION['profesor']['area_investigacion'] = $areaInvestigacion;
				$_SESSION['profesor']['tesis'] = $tesis;
				$_SESSION['profesor']['resumen'] = $resumen;
				$_SESSION['profesor']['publicaciones'] = $publicaciones;
						
				$_SESSION['mensaje_exito'] = "Exito en modificar los datos";
				header('Location: perfilProfesor.php');
			}else{
				$_SESSION['mensaje_error'] = "Error al modificar los datos";
				header('Location: perfilProfesor.php');
			}
		}	
	}
?>