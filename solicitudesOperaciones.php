<?php
	include('conectar.php');
	session_start();
	
	$idAlum = mysqli_real_escape_string($mysqli, $_POST['idAlum']);
	$idProf = mysqli_real_escape_string($mysqli, $_POST['idProf']);
	$idSolicitud = mysqli_real_escape_string($mysqli, $_POST['idSolicitud']);
	$estatus = mysqli_real_escape_string($mysqli, $_POST['estatus']);
	$estatusBD = mysqli_real_escape_string($mysqli, $_POST['estatusBD']);
	$cupo = mysqli_real_escape_string($mysqli, $_POST['cupo']);

	if(isset($_POST['buscar'])){
		$consulta = "";
		
		$fCodigoA = mysqli_real_escape_string($mysqli, $_POST['codigoA']);
		$fCodigoP = mysqli_real_escape_string($mysqli, $_POST['codigoP']);
		$fEstatus = mysqli_real_escape_string($mysqli, $_POST['estatus']);
		$fFecha = mysqli_real_escape_string($mysqli, $_POST['fecha']);
		
		if($fCodigoA != ""){
			$consulta .= "codigo_alumno=" . $fCodigoA;
		}
		if($fCodigoP != ""){
			if($consulta != ""){
				$consulta .= "&codigo_profesor=" . $fCodigoP;
			}else{
				$consulta .= "codigo_profesor=" . $fCodigoP;
			}
		}
		if($fEstatus != ""){
			if($consulta != ""){
				$consulta .= "&estatus=" . $fEstatus;
			}else{
				$consulta .= "estatus=" . $fEstatus;
			}
		}
		if($fFecha != ""){
			if($consulta != ""){
				$consulta .= "&fecha=" . $fFecha;
			}else{
				$consulta .= "fecha=" . $fFecha;
			}
		}
		
		header('Location: solicitudesAdmin.php?' . $consulta);
	}
	
	if(isset($_POST['guardar'])){
		
		$consulta = "";
		
		$urlCodigoA = mysqli_real_escape_string($mysqli, $_POST['urlCodigoA']);
		$urlCodigoP = mysqli_real_escape_string($mysqli, $_POST['urlCodigoP']);
		$urlEstatus = mysqli_real_escape_string($mysqli, $_POST['urlEstatus']);
		$urlFecha = mysqli_real_escape_string($mysqli, $_POST['urlFecha']);
		
		if($urlCodigoA != ""){
			$consulta .= "codigo_alumno=" . $urlCodigoA;
		}
		if($urlCodigoP != ""){
			if($consulta != ""){
				$consulta .= "&codigo_profesor=" . $urlCodigoP;
			}else{
				$consulta .= "codigo_profesor=" . $urlCodigoP;
			}
		}
		if($urlEstatus != ""){
			if($consulta != ""){
				$consulta .= "&estatus=" . $urlEstatus;
			}else{
				$consulta .= "estatus=" . $urlEstatus;
			}
		}
		if($urlFecha != ""){
			if($consulta != ""){
				$consulta .= "&fecha=" . $urlFecha;
			}else{
				$consulta .= "fecha=" . $urlFecha;
			}
		}
		
		if($estatus == '1'){
			if($estatusBD == '1'){
				$_SESSION['mensaje_error'] = "Error, la solicitud ya se encuentra en espera";
				header('Location: solicitudesAdmin.php?' . $consulta);
			}else{
				$sql = "UPDATE solicitudes SET estatus = '1' WHERE id = '$idSolicitud'";
		
				if (mysqli_query($mysqli, $sql)){
					if($estatusBD == '3'){
						$cupo -= 1;
					
						$sqlUpadate = "UPDATE profesores SET cupo_alumnos = '$cupo' 
						WHERE profesores.id = '$idProf'";
					
						if (mysqli_query($mysqli, $sqlUpadate)){
							$_SESSION['mensaje_exito'] = "Solicitud en espera";
							header('Location: solicitudesAdmin.php?' . $consulta);
						}else {
							$_SESSION['mensaje_error'] = "Error al realizar acción";
							header('Location: solicitudesAdmin.php?' . $consulta);
						}
					} else{
						$_SESSION['mensaje_exito'] = "Solicitud en espera";
						header('Location: solicitudesAdmin.php?' . $consulta);
					}	
				} else{
					$_SESSION['mensaje_error'] = "Error al realizar acción";
					header('Location: solicitudesAdmin.php?' . $consulta);
				}
			}
		}
		elseif($estatus == '2'){
			if($estatusBD == '2'){
				$_SESSION['mensaje_error'] = "Error, la solicitud ya se encuentra rechazada";
				header('Location: solicitudesAdmin.php?' . $consulta);
			}else{
				$sql = "UPDATE solicitudes SET estatus = '2' WHERE id = '$idSolicitud'";
		
				if (mysqli_query($mysqli, $sql)){
					if($estatusBD == '3'){
						$cupo -= 1;
					
						$sqlUpadate = "UPDATE profesores SET cupo_alumnos = '$cupo' 
						WHERE profesores.id = '$idProf'";
					
						if (mysqli_query($mysqli, $sqlUpadate)){
							$_SESSION['mensaje_exito'] = "Solicitud rechazada";
							header('Location: solicitudesAdmin.php?' . $consulta);
						}else {
							$_SESSION['mensaje_error'] = "Error al realizar acción";
							header('Location: solicitudesAdmin.php?' . $consulta);
						}
					} else{
						$_SESSION['mensaje_exito'] = "Solicitud rechazada";
						header('Location: solicitudesAdmin.php?' . $consulta);
					}	
				} else{
					$_SESSION['mensaje_error'] = "Error al realizar acción";
					header('Location: solicitudesAdmin.php?' . $consulta);
				}
			}
		}
		elseif($estatus == '3'){
			if($estatusBD == '3'){
				$_SESSION['mensaje_error'] = "Error, la solicitud ya se encuentra aceptada";
				header('Location: solicitudesAdmin.php?' . $consulta);
			}else{
				if($cupo >= 5){
					$_SESSION['mensaje_error'] = "Error, cupo lleno";
					header('Location: solicitudesAdmin.php?' . $consulta);
				}else{
					$cupo += 1;
					
					$sql = "UPDATE solicitudes, profesores SET solicitudes.estatus = '3', profesores.cupo_alumnos = '$cupo'
						WHERE solicitudes.id = '$idSolicitud' AND profesores.id = '$idProf'";
					
					if (mysqli_query($mysqli, $sql)){	
						$sqlUpadate = "UPDATE solicitudes SET estatus = '2' WHERE id_alumno = '$idAlum' AND estatus = '1'";
					
						if (mysqli_query($mysqli, $sqlUpadate)){
							$_SESSION['mensaje_exito'] = "Solicitud aceptada";
							header('Location: solicitudesAdmin.php?' . $consulta);
					
						} else {
						$_SESSION['mensaje_error'] = "Error al realizar acción";
						header('Location: solicitudesAdmin.php?' . $consulta);
						}
					}else{
					$_SESSION['mensaje_error'] = "Error al realizar acción";
					header('Location: solicitudesAdmin.php?' . $consulta);
					}
				}
			}
		}
		elseif($estatus == '4'){
			if($estatusBD == '4'){
				$_SESSION['mensaje_error'] = "Error, la solicitud ya se encuentra concluida";
				header('Location: solicitudesAdmin.php?' . $consulta);
			}else{
				if($estatusBD == '3'){
					$cupo -= 1;
				}
		
				$sql = "UPDATE solicitudes, profesores SET solicitudes.estatus = '4', profesores.cupo_alumnos = '$cupo' 
					WHERE solicitudes.id = '$idSolicitud' AND profesores.id = '$idProf'";
			
				if (mysqli_query($mysqli, $sql)){
					$_SESSION['mensaje_exito'] = "Solicitud concluida";
					header('Location: solicitudesAdmin.php?' . $consulta);
						
				} else{
					$_SESSION['mensaje_error'] = "Error al realizar acción";
					header('Location: solicitudesAdmin.php?' . $consulta);
				}
			}
		}
		elseif($estatus == '5'){
			$sql = "DELETE FROM solicitudes WHERE id = '$idSolicitud'";
		
			if (mysqli_query($mysqli, $sql)){
				if($estatusBD == '3'){
					$cupo -= 1;
					
					$sqlUpadate = "UPDATE profesores SET cupo_alumnos = '$cupo' 
					WHERE profesores.id = '$idProf'";
					
					if (mysqli_query($mysqli, $sqlUpadate)){
						$_SESSION['mensaje_exito'] = "Solicitud eliminada";
						header('Location: solicitudesAdmin.php?' . $consulta);
					}else {
						$_SESSION['mensaje_error'] = "Error al realizar acción";
						header('Location: solicitudesAdmin.php?' . $consulta);
					}
				} else{
					$_SESSION['mensaje_exito'] = "Solicitud eliminada";
					header('Location: solicitudesAdmin.php?' . $consulta);
				}
			} else{
				$_SESSION['mensaje_error'] = "Error al realizar acción";
				header('Location: solicitudesAdmin.php?' . $consulta);
			}
		}
		else{
			$_SESSION['mensaje_error'] = "Favor de introducir un valor valido";
			header('Location: solicitudesAdmin.php?' . $consulta);
		}
	}
	
	if(isset($_POST['concluir'])){
		$cupo -= 1;
		
		$sql = "UPDATE solicitudes, profesores SET solicitudes.estatus = '4', profesores.cupo_alumnos = '$cupo' 
			WHERE solicitudes.id = '$idSolicitud' AND profesores.id = '$idProf'";
			
		if (mysqli_query($mysqli, $sql)){
			$_SESSION['mensaje_exito'] = "Solicitud concluida";
			header('Location: panelDelProfesor.php');
						
		} else{
			$_SESSION['mensaje_error'] = "Error al realizar acción";
			header('Location: panelDelProfesor.php');
		}
	}
		
	?>