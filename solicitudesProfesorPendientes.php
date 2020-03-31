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
		<h5 class="card-title">Solicitudes</h5>
        <p class="card-text">Aquí puedes ver las solicitudes con estatus en Espera que has recibido</p>
       	  
	<!--Mostrar busqueda de profesores-->
	<?php
		
		$idProfesor = $profesor['id'];
		
		$sql = "SELECT a.nombre, a.apellido_pat, a.apellido_mat, p.carrera, 
			p.sigla, s.estatus, s.fecha FROM alumnos a 
			INNER JOIN posgrados p ON a.id_posgrado = p.id
			INNER JOIN solicitudes s ON a.id = s.id_alumno 
			WHERE s.estatus = '1' AND s.id_profesor = '$idProfesor' 
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
					echo '</tr>';
				echo '</thead>';
							
				while($row = mysqli_fetch_assoc($result)){
					$nombreAlum = $row["nombre"];
					$apellidoPat = $row["apellido_pat"];
					$apellidoMat = $row["apellido_mat"];
					
					$posgrado = $row["carrera"];
					$sigla = $row["sigla"];
								
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
						echo '<td class="text-left">' . $nombreAlum . " " . $apellidoPat . " " . $apellidoMat . '</td>';
						
						echo '<td class="text-left">' . $posgrado . " (" . $sigla . ")" . '</td>';
						echo '<td>' . $estatus . '</td>';
						echo '<td style="width: 15%">' . $fechaformat . '</td>';
						
					echo '</tr>';
				}
				echo '</table>';
			echo '</div>';
		}

	?>
	</div>
  </body>
</html>