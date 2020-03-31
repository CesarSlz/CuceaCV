<?php
	include('conectar.php');
	session_start();

	if(isset($_POST['buscarA'])){
		$consulta = "";
		
		$fCodigoA = mysqli_real_escape_string($mysqli, $_POST['codigoA']);
		$fEstatus = mysqli_real_escape_string($mysqli, $_POST['estatus']);
		
		if($fCodigoA != ""){
			$consulta .= "codigo_alumno=" . $fCodigoA;
		}
		if($fEstatus != ""){
			if($consulta != ""){
				$consulta .= "&estatus=" . $fEstatus;
			}else{
				$consulta .= "estatus=" . $fEstatus;
			}
		}
		
		header('Location: listadoAlumnos.php?' . $consulta);
	}
	
	if(isset($_POST['ModificarA'])){
		$id = mysqli_real_escape_string($mysqli, $_POST['idAlum']);
		$posgrado = mysqli_real_escape_string($mysqli, $_POST['posgrado']);
		$codigo  = mysqli_real_escape_string($mysqli, $_POST['codigo']);
		$password  = mysqli_real_escape_string($mysqli, $_POST['contraseña']);
		$nombre = mysqli_real_escape_string($mysqli, $_POST['nombre']);
		$apellidoPat = mysqli_real_escape_string($mysqli, $_POST['apellidoPat']);
		$apellidoMat = mysqli_real_escape_string($mysqli, $_POST['apellidoMat']);
		$correo  = mysqli_real_escape_string($mysqli, $_POST['correo']);
		$telefono  = mysqli_real_escape_string($mysqli, $_POST['telefono']);
		$cicloIngreso  = mysqli_real_escape_string($mysqli, $_POST['cicloIngreso']);
		$genero  = mysqli_real_escape_string($mysqli, $_POST['genero']);
		$estatus  = mysqli_real_escape_string($mysqli, $_POST['estatus']);
		
		$sql = "UPDATE alumnos SET id_posgrado = '$posgrado', codigo = '$codigo', contraseña = '$password', nombre = '$nombre',
		apellido_pat = '$apellidoPat', apellido_mat = '$apellidoMat', correo = '$correo', telefono = '$telefono',
		ciclo_ingreso = '$cicloIngreso', genero = '$genero', estatus = '$estatus' WHERE id = '$id'";
		
		if (mysqli_query($mysqli, $sql)){
			$_SESSION['mensaje_exito'] = "Exito en actualizar los datos del alumno";
			header('Location: modificarAlumno.php?id='. $id);
		}else{
			$_SESSION['mensaje_error'] = "Error al actualizar los datos del alumno";
			header('Location: modificarAlumno.php?id='. $id);
		}
	}
	
	if(isset($_POST['EliminarA'])){
		$consulta = "";
		
		$id = mysqli_real_escape_string($mysqli, $_POST['idAlum']);
		$urlCodigoA = mysqli_real_escape_string($mysqli, $_POST['urlCodigoA']);
		$urlEstatus = mysqli_real_escape_string($mysqli, $_POST['urlEstatus']);
		
		if($urlCodigoA != ""){
			$consulta .= "codigo_alumno=" . $urlCodigoA;
		}
		if($urlEstatus != ""){
			if($consulta != ""){
				$consulta .= "&estatus=" . $urlEstatus;
			}else{
				$consulta .= "estatus=" . $urlEstatus;
			}
		}
		
		$sql = "DELETE FROM alumnos WHERE id = '$id'";
		
		if (mysqli_query($mysqli, $sql)){
			$_SESSION['mensaje_exito'] = "Alumno eliminado";
			header('Location: listadoAlumnos.php?' . $consulta);
		}else{
			$_SESSION['mensaje_error'] = "Error al eliminar alumno";
			header('Location: listadoAlumnos.php?' . $consulta);
		}
	}
	
	if(isset($_POST['buscarP'])){
		$consulta = "";
		
		$fCodigoP = mysqli_real_escape_string($mysqli, $_POST['codigoP']);
		$fEstatus = mysqli_real_escape_string($mysqli, $_POST['estatus']);
		
		if($fCodigoP != ""){
			$consulta .= "codigo_profesor=" . $fCodigoP;
		}
		if($fEstatus != ""){
			if($consulta != ""){
				$consulta .= "&estatus=" . $fEstatus;
			}else{
				$consulta .= "estatus=" . $fEstatus;
			}
		}
		
		header('Location: listadoProfesores.php?' . $consulta);
	}
	
	if(isset($_POST['ModificarP'])){
		$id = mysqli_real_escape_string($mysqli, $_POST['idProf']);
		$codigo  = mysqli_real_escape_string($mysqli, $_POST['codigo']);
		$password  = mysqli_real_escape_string($mysqli, $_POST['contraseña']);
		$nombre = mysqli_real_escape_string($mysqli, $_POST['nombre']);
		$apellidoPat = mysqli_real_escape_string($mysqli, $_POST['apellidoPat']);
		$apellidoMat = mysqli_real_escape_string($mysqli, $_POST['apellidoMat']);
		$correo  = mysqli_real_escape_string($mysqli, $_POST['correo']);
		$telefono  = mysqli_real_escape_string($mysqli, $_POST['telefono']);
		$biografia = mysqli_real_escape_string($mysqli, $_POST['biografia']);
		
		foreach($_POST["areaInvestigacion"] as $key => $value) {
			$areaInvestigacion .= mysqli_real_escape_string($mysqli, $value) . "_";
		}
		
		foreach($_POST["publicaciones"] as $key => $value) {
			$publicaciones .= mysqli_real_escape_string($mysqli, $value) . "_";
		}
		
		$tesis = mysqli_real_escape_string($mysqli, $_POST["tesis"]);
		$resumen = mysqli_real_escape_string($mysqli, $_POST["resumen"]);
		$cupo = mysqli_real_escape_string($mysqli, $_POST["cupo"]);
		$genero  = mysqli_real_escape_string($mysqli, $_POST['genero']);
		$estatus  = mysqli_real_escape_string($mysqli, $_POST['estatus']);
		
		$nombreImg = $_FILES['foto']['name'];
		$tipo = $_FILES['foto']['type'];
		$tamano = $_FILES['foto']['size'];
		
		if($nombreImg != null){
			if(($_FILES['foto']['size'] <= 400000)){
				if(($_FILES['foto']['type'] == "image/png") || ($_FILES['foto']['type'] == "image/jpg") || ($_FILES['foto']['type'] == "image/jpeg")){
					$directorio = $_SERVER['DOCUMENT_ROOT'] . '/cuceacv/styles/img/profesores/';
					
					move_uploaded_file($_FILES['foto']['tmp_name'], $directorio.$nombreImg);
					
					$sql = "UPDATE profesores SET codigo = '$codigo', contraseña = '$password', nombre = '$nombre', apellido_pat = '$apellidoPat', apellido_mat = '$apellidoMat', correo = '$correo', telefono = '$telefono', biografia = '$biografia', area_investigacion = '$areaInvestigacion', tesis = '$tesis', resumen = '$resumen', publicaciones = '$publicaciones', cupo_alumnos = '$cupo', genero = '$genero', estatus = '$estatus', foto = '$nombreImg' WHERE id = '$id'";
					
					if (mysqli_query($mysqli, $sql)){
						$_SESSION['mensaje_exito'] = "Exito en actualizar los datos del profesor";
						header('Location: modificarProfesor.php?id='. $id);
					}else{
						$_SESSION['mensaje_error'] = "Error al actualizar los datos del profesor";
						header('Location: modificarProfesor.php?id='. $id);
					}
				}else{
					$_SESSION['mensaje_error'] = "El formato de la fotografía no esta permitido";
					header('Location: modificarProfesor.php?id='. $id);
				}
			}else{
				$_SESSION['mensaje_error'] = "La fotografía excede el tamaño permitido";
				header('Location: modificarProfesor.php?id='. $id);
			}
		}else{
			$sql = "UPDATE profesores SET codigo = '$codigo', contraseña = '$password', nombre = '$nombre', apellido_pat = '$apellidoPat', apellido_mat = '$apellidoMat', correo = '$correo', telefono = '$telefono', biografia = '$biografia', area_investigacion = '$areaInvestigacion', tesis = '$tesis', resumen = '$resumen', publicaciones = '$publicaciones', cupo_alumnos = '$cupo', genero = '$genero', estatus = '$estatus' WHERE id = '$id'";
			
			if (mysqli_query($mysqli, $sql)){
				$_SESSION['mensaje_exito'] = "Exito en actualizar los datos del profesor";
				header('Location: modificarProfesor.php?id='. $id);
			}else{
				$_SESSION['mensaje_error'] = "Error al actualizar los datos del profesor";
				header('Location: modificarProfesor.php?id='. $id);
			}
		}		 
	}
	
	if(isset($_POST['EliminarP'])){
		$consulta = "";
		
		$id = mysqli_real_escape_string($mysqli, $_POST['idProf']);
		$urlCodigoP = mysqli_real_escape_string($mysqli, $_POST['urlCodigoP']);
		$urlEstatus = mysqli_real_escape_string($mysqli, $_POST['urlEstatus']);
		
		if($urlCodigoP != ""){
			$consulta .= "codigo_alumno=" . $urlCodigoP;
		}
		if($urlEstatus != ""){
			if($consulta != ""){
				$consulta .= "&estatus=" . $urlEstatus;
			}else{
				$consulta .= "estatus=" . $urlEstatus;
			}
		}
		
		$sql = "DELETE FROM profesores WHERE id = '$id'";
		
		if (mysqli_query($mysqli, $sql)){
			$_SESSION['mensaje_exito'] = "Profesor eliminado";
			header('Location: listadoProfesores.php?' . $consulta);
		}else{
			$_SESSION['mensaje_error'] = "Error al eliminar profesor";
			header('Location: listadoProfesores.php?' . $consulta);
		}
	}
		
	?>