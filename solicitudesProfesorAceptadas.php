<?php
	include('conectar.php');
	session_start();
?>

<!DOCTYPE html>
<html>
  <head>
	<title>Solicitudes del profesor</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie-edge">
    <link rel="stylesheet" type="text/css" href="styles/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="styles/css/estilo.css">
  </head>
  <body>
  
    <!-- Contenido -->
	<div class="card-body">
		<h5 class="card-title">Alumnos</h5>
        <p class="card-text">Aquí puedes ver a los alumnos que actualmente estan a tu cargo</p>
       	  
	<!--Mostrar busqueda de profesores-->
	<?php
		
		$idProfesor = $profesor['id'];
		
		$sql = "SELECT a.id as idAlum, a.nombre, a.apellido_pat, a.apellido_mat, p.carrera, p.sigla,
			s.id as idSol, s.estatus, s.fecha, profesores.cupo_alumnos FROM profesores, alumnos a 
			INNER JOIN posgrados p ON a.id_posgrado = p.id
			INNER JOIN solicitudes s ON a.id = s.id_alumno 
			WHERE s.estatus = '3' AND s.id_profesor = '$idProfesor' AND profesores.id = '$idProfesor' 
			ORDER BY s.fecha ASC";
		 
		$result = mysqli_query($mysqli, $sql);

		if (mysqli_num_rows($result) > 0) {
			
			echo '<div class="table-responsive">';
				echo '<table class="table table-hover">';
						
				echo '<thead class="thead-light">';
					echo '<tr>';
						echo '<th>Alumno</th>';
						echo '<th>Maestría</th>';
						echo '<th>Estatus</th>';
						echo '<th>Fecha</th>';
						echo '<th>Acciones</th>';
					echo '</tr>';
				echo '</thead>';
							
				while($row = mysqli_fetch_assoc($result)){
					$idAlum = $row["idAlum"];
					$nombreAlum = $row["nombre"];
					$apellidoPat = $row["apellido_pat"];
					$apellidoMat = $row["apellido_mat"];
					
					$posgrado = $row["carrera"];
					$sigla = $row["sigla"];
					
					$cupo = $row["cupo_alumnos"];
					
					$idSolicitud = $row["idSol"];
					$estatus = $row["estatus"];
					
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
						echo '<td class="align-middle text-left">' . $nombreAlum . " " . $apellidoPat . " " . $apellidoMat . '</td>';
						
						echo '<td class="align-middle text-left">' . $posgrado . " (" . $sigla . ")" . '</td>';
						echo '<td class="align-middle">' . $estatus . '</td>';
						echo '<td class="align-middle" style="width: 15%">' . $fechaformat . '</td>';
						
						echo '<form action="solicitudesOperaciones.php" method="post">';
							
							// input con los valores que sirver para manipular la informacion de las tablas en las base de datos
							echo '<input type="hidden" name="idAlum" value="' . $idAlum . '">';
							echo '<input type="hidden" name="idProf" value="' . $idProfesor . '">';
							echo '<input type="hidden" name="idSolicitud" value="' . $idSolicitud . '">';
							echo '<input type="hidden" name="estatus" value="' . $estatus . '">';
							echo '<input type="hidden" name="cupo" value="' . $cupo . '">';
							
							echo '<td class="align-middle" style="width: 10%"><input type="submit" class="btn btn-danger text-white" 
								name="concluir" value="Concluir"></td>';
							
						echo'</form>';
						
					echo '</tr>';
				}
				echo '</table>';
				echo '<p>*Solamente CONCLUYA con los registros de los alumnos que hayan completado su tesis</p>';
			echo '</div>';
		}

	?>
	</div>
  </body>
</html>