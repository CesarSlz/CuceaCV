<?php
	include('conectar.php');
	session_start();
?>

<!DOCTYPE html>
<html>
  <head>
	<title>Lista de Profesores</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie-edge">
    <link rel="stylesheet" type="text/css" href="styles/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="styles/css/estilo.css">
  </head>
  <body>
  
    <!-- Contenido -->
	<div class="card-body">
        <h5 class="card-title ">Buscar</h5>
        <p class="card-text">Aqui puedes buscar un Director de Tesis de acuerdo con la área de investigación o el título de tesis del profesor</p>
				
		<center>
			<form class="form mt-3" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="get">
				<div class="d-flex">
					<div class="flex-grow-1">
						<input class="form-control mt-1 mb-3" type="text" name="busqueda" 
							placeholder="Introduce una área de investigación o título de tesis" pattern="^\b([A-z-Á-ú ,]+\b)*$">
					</div>
					<div class="ml-1">
						<input class="btn degradado-gris text-secondary mt-1" type="submit" name="buscar" value="Buscar">
					</div>
				</div>
			</form>
		</center>
       	  
	<!--Mostrar busqueda de profesores-->
	<?php
	if(isset($_GET['buscar'])){
		$busc = mysqli_real_escape_string($mysqli, $_GET['busqueda']);
		$dirFotos = 'styles/img/profesores/';
		
		$sql = "SELECT id, nombre, apellido_pat, apellido_mat, area_investigacion, tesis, cupo_alumnos, foto FROM
			profesores WHERE area_investigacion LIKE '%$busc%' OR tesis LIKE '%$busc%' ORDER BY nombre";
		 
		$result = mysqli_query($mysqli, $sql);

		if (mysqli_num_rows($result) > 0) {
			
			echo '<h5 class="float-left mb-3">Resultados</h5>';
			echo '<div class="table-responsive">';
				echo '<table class="table table-hover">';
						
				echo '<thead class="thead-light">';
					echo '<tr>';
						echo '<th>Fotografía</th>';
						echo '<th>Nombre</th>';
						echo '<th>Área de Investigación</th>';
						echo '<th>Tesis</th>';
						echo '<th>Cupo</th>';
					echo '</tr>';
				echo '</thead>';
							
				while($row = mysqli_fetch_assoc($result)){
					$id = $row['id'];
					$foto = $row["foto"];
					$nombre = $row["nombre"];
					$apellidoPat = $row["apellido_pat"];
					$apellidoMat = $row["apellido_mat"];
					$areaInvestigacion = $row["area_investigacion"];
					$tesis = $row["tesis"];
					$cupoAlumnos = $row["cupo_alumnos"];
					
					if($areaInvestigacion != ""){
						$areaReplace = str_replace("_" , ", ", $areaInvestigacion);
						$areaReplace = str_replace("., " , ", ", $areaReplace);
						$areaReplace = str_replace(",, " , ", ", $areaReplace);
						$areaReplace = substr_replace($areaReplace, ".", strlen($areaReplace)-2);
						
					}else{
						$areaReplace = "";
					}
							
					echo '<tr>';
						echo '<td><img class="fotoTabla" src="' . $dirFotos.$foto . '"></td>';
						
						// Enviar el id del profesor a traves de la URL
						echo '<td class="text-left"><a href="descripcionProfesor.php?id=' . $id .'">' . $nombre . " " . $apellidoPat . " " . $apellidoMat . '</a></td>';
						
						echo '<td class="text-left">' . $areaReplace . '</td>';
						echo '<td class="text-left">' . $tesis . '</td>';
						echo '<td>' . $cupoAlumnos . "/5" . '</td>';
					echo '</tr>';
				}
				echo '</table>';
			echo '</div>';
		}else {
			echo '<h5 class="float-left mb-3">Ninguna coincidencia</h5>';
		}
	}

	?>
	</div>
  </body>
</html>

