<?php
	include('conectar.php');
	session_start();
?>

<!DOCTYPE html>
<html>
  <head>
	<title>Solicitudes del Estudiante</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie-edge">
    <link rel="stylesheet" type="text/css" href="styles/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="styles/css/estilo.css">
  </head>
  <body>
  
    <!-- Contenido -->
	<div class="card-body">
		<h5 class="card-title">Solicitudes</h5>
        <p class="card-text">Aquí puedes ver tus solicitudes y consultar su estatus</p>
       	  
	<!--Mostrar busqueda de profesores-->
	<?php
		
		$idAlumno = $alumno['id'];
		$sql = "SELECT profesores.id, profesores.nombre, profesores.apellido_pat, profesores.apellido_mat,
			profesores.area_investigacion, solicitudes.estatus, solicitudes.fecha FROM solicitudes
			INNER JOIN profesores ON solicitudes.id_profesor = profesores.id 
			WHERE solicitudes.estatus < 5 AND id_alumno = '$idAlumno' ORDER BY solicitudes.fecha ASC";
		 
		$result = mysqli_query($mysqli, $sql);

		if (mysqli_num_rows($result) > 0) {
			
			echo '<div class="table-responsive">';
				echo '<table class="table table-hover">';
						
				echo '<thead class="thead-light">';
					echo '<tr>';
						echo '<th>Profesor</th>';
						echo '<th>Area de Investigación</th>';
						echo '<th>Estatus</th>';
						echo '<th>Fecha</th>';
					echo '</tr>';
				echo '</thead>';
							
				while($row = mysqli_fetch_assoc($result)){
					$idProf = $row["id"];
					$nombreProf = $row["nombre"];
					$apellidoPat = $row["apellido_pat"];
					$apellidoMat = $row["apellido_mat"];
					$areaInvestigacion = $row["area_investigacion"];
					
					if($areaInvestigacion != ""){
						$areaReplace = str_replace("_" , ", ", $areaInvestigacion);
						$areaReplace = str_replace("., " , ", ", $areaReplace);
						$areaReplace = str_replace(",, " , ", ", $areaReplace);
						$areaReplace = substr_replace($areaReplace, ".", strlen($areaReplace)-2);
						
					}else{
						$areaReplace = "";
					}
					
					if($row["estatus"] == '1'){
						$estatus = "Espera";
					}elseif($row["estatus"] == '2'){
						$estatus = "Rechazada";
					}elseif($row["estatus"] == '3'){
						$estatus = "Aceptada";
					}else{
						$estatus = "Concluida";
					}
					
					$fecha = $row["fecha"];
					$fechaformat = date("d/m/Y", strtotime($fecha));
								
					echo '<tr>';
						echo '<td class="text-left"><a href="descripcionProfesor.php?id=' . $idProf .'">' . $nombreProf . " " . $apellidoPat . " " . $apellidoMat . '</a></td>';
						
						echo '<td class="text-left">' . $areaReplace . '</td>';
						echo '<td class="text-left">' . $estatus . '</td>';
						echo '<td style="width: 15%">' . $fechaformat . '</td>';
					echo '</tr>';
				}
				echo '</table>';
				echo '<p>*Favor de ponerse en contacto con el profesor una vez que el estatus cambie a ACEPTADA</p>';
			echo '</div>';
		}

	?>
	</div>
  </body>
</html>

