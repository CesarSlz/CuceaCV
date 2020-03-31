<?php
	include('conectar.php');
	session_start();
	if(isset($_SESSION["admin"])){
	  $admin = $_SESSION["admin"];
?>

<!DOCTYPE html>
<html>
  <head>
	<title>Solicitudes pendientes</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie-edge">
	<link rel="stylesheet" type="text/css" href="styles/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="styles/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="header/header.css">
	<link rel="stylesheet" type="text/css" href="styles/css/estilo.css">
  </head>
  
  <body>
  
    <!-- Header -->
    <?php include("header/header.php"); ?>
  
    <!-- Contenido -->
	<div class="container border-right border-left">
	
	  <center>
		<h2 class="main-text mt-3">Solicitudes</h2>
      </center>
      
      <div class="row mx-5 mb-3 mt-1">

        <div class="col-12 mx-auto blueHeaders rounded my-3 border py-2">
          <center>
		    <h4>Cambia el estatus de la solicitudes</h4>
			
		  </center>
        </div>

        <div class="col-12 mx-auto p-0">
			<form class="form mt-3" action="solicitudesOperaciones.php" method="post">
				<h5>Filtro de solicitudes</h5>
				<div class="row">
					
					<div class="col">
						<input class="form-control mt-1 mb-3" type="text" name="codigoA" placeholder="código de alumno" pattern="[0-9]{1,9}">
					</div>
					<div class="col">
						<input class="form-control mt-1 mb-3" type="text" name="codigoP" placeholder="código de profesor" pattern="[0-9]{1,9}">
					</div>
					<div class="col">
						<select class="form-control mt-1 mb-3" name="estatus">
							<option value="" disabled selected>estatus de solicitud</option>
							<option value="1">Espera</option>
							<option value="2">Rechazada</option>
							<option value="3">Aceptada</option>
							<option value="4">Concluida</option>
						</select>
					</div>
					<div class="col">
						<input class="form-control mt-1 mb-3" type="text" onclick="(type='date')" onblur="(type='text')" name="fecha" 
							placeholder="fecha de solicitud">
					</div>
					<div class="col-md-auto">
						<input class="btn degradado-gris text-secondary mt-1 mb-3 float-right" type="submit" name="buscar" value="Buscar">
					</div>
				</div>
			</form>
			
			<p class="text-center"><b>Espera</b> = 1, <b>Rechazada</b> = 2, <b>Aceptada</b> = 3, <b>Concluida</b> = 4, <b>Eliminar</b> = 5</p>
			  
			<?php
			
			$urlCodigoA = mysqli_real_escape_string($mysqli, $_GET['codigo_alumno']);
			$urlCodigoP = mysqli_real_escape_string($mysqli, $_GET['codigo_profesor']);
			$urlEstatus = mysqli_real_escape_string($mysqli, $_GET['estatus']);
			$urlFecha = mysqli_real_escape_string($mysqli, $_GET['fecha']);

			
			$sql = "SELECT s.id, a.id as idAlum, a.nombre as nombA, a.apellido_pat as apePatA, a.apellido_mat as apeMatA,
				p.nombre as nombP, p.id as idProf, p.apellido_pat as apePatP , p.apellido_mat as apeMatP, p.cupo_alumnos,
				s.estatus, s.fecha, ps.carrera FROM solicitudes s
				INNER JOIN alumnos a ON s.id_alumno = a.id 
				INNER JOIN profesores p ON s.id_profesor = p.id
				INNER JOIN posgrados ps ON a.id_posgrado = ps.id";
				
			if(!empty($urlCodigoA) || !empty($urlCodigoP) || !empty($urlEstatus) || !empty($urlFecha)){
				$sql .= " WHERE";
				if(!empty($urlCodigoA)){
					$sql .= " a.codigo = '$urlCodigoA'";
				}
				if(!empty($urlCodigoP)){
					if(!empty($urlCodigoA)){
						$sql .= " AND p.codigo = '$urlCodigoP'";
					}else{
						$sql .= " p.codigo = '$urlCodigoP'";
					}
				}
				if(!empty($urlEstatus)){
					if(!empty($urlCodigoA) || !empty($urlCodigoP)){
						$sql .= " AND s.estatus = '$urlEstatus'";
					} else{
						$sql .= " s.estatus = '$urlEstatus'";
					}
				}
				if(!empty($urlFecha)){
					if(!empty($urlCodigoA) || !empty($urlCodigoP) || !empty($urlEstatus)){
						$sql .= " AND s.fecha = '$urlFecha'";
					}else{
						$sql .= " s.fecha = '$urlFecha'";
					}
				}
			}
			
			$sql .= " ORDER BY s.fecha ASC, a.nombre ASC";
			 
			$result = mysqli_query($mysqli, $sql);

			if (mysqli_num_rows($result) > 0) {
				
				echo '<div class="table-responsive">';
					echo '<table class="table table-hover border">';
							
					echo '<thead class="thead-light">';
						echo '<tr>';
							echo '<th class="text-center">ID</th>';
							echo '<th class="text-center">Alumno</th>';
							echo '<th class="text-center">Posgrado</th>';
							echo '<th class="text-center">Profesor</th>';
							echo '<th class="text-center">Cupo</th>';
							echo '<th class="text-center">Estatus</th>';
							echo '<th class="text-center">Fecha</th>';
							echo '<th class="text-center">Acciones</th>';
						echo '</tr>';
					echo '</thead>';
								
					while($row = mysqli_fetch_assoc($result)){
						$idSolicitud = $row["id"];
						
						$idAlum = $row["idAlum"];
						$nombreAlum = $row["nombA"];
						$apellidoPatAlum = $row["apePatA"];
						$apellidoMatAlum = $row["apeMatA"];
						
						$idProf = $row["idProf"];
						$nombreProf = $row["nombP"];
						$apellidoPatProf = $row["apePatP"];
						$apellidoMatProf = $row["apeMatP"];
						$cupo = $row["cupo_alumnos"];
						$carrera = $row["carrera"];
						
						$estatus = $row["estatus"];
						$estatusBD = $row["estatus"];
						
						$fecha = $row["fecha"];
						
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
							echo '<form action="solicitudesOperaciones.php" method="post">';
							
								echo '<td class="text-center align-middle">' . $idSolicitud . '</td>';
								echo '<td class="text-left align-middle">' . $nombreAlum . " " . $apellidoPatAlum . " " . $apellidoMatAlum . '</td>';
								echo '<td class="text-left align-middle">' . $carrera . '</td>';
								echo '<td class="text-left align-middle">' . $nombreProf . " " . $apellidoPatProf . " " . $apellidoMatProf . '</td>';
								echo '<td class="text-center align-middle">' . $cupo . '/5</td>';
								echo '<td class="align-middle"><input id="estatus' . $idSolicitud . '" class="form-control text-center" 
									style="background-color: transparent; border: 0px solid;" type="text" name="estatus" value="' . $estatus . '" pattern="[1-5]{1}" readonly></td>';
								echo '<td class="text-center align-middle">' . $fechaformat . '</td>';
								
								// input con los valores que sirver para manipular la informacion de las tablas en las base de datos
								echo '<input type="hidden" name="idAlum" value="' . $idAlum . '">';
								echo '<input type="hidden" name="idProf" value="' . $idProf . '">';
								echo '<input type="hidden" name="idSolicitud" value="' . $idSolicitud . '">';
								echo '<input type="hidden" name="estatusBD" value="' . $estatusBD . '">';
								echo '<input type="hidden" name="cupo" value="' . $cupo . '">';
								
								// input para conservar la url despues de hacer un cambio de estatus en las solicitudes
								echo '<input type="hidden" name="urlCodigoA" value="' . $urlCodigoA . '">';
								echo '<input type="hidden" name="urlCodigoP" value="' . $urlCodigoP . '">';
								echo '<input type="hidden" name="urlEstatus" value="' . $urlEstatus . '">';
								echo '<input type="hidden" name="urlFecha" value="' . $urlFecha . '">';
									
								echo '<td class="text-center align-middle" style="width: 10%">
										<a id="' . $idSolicitud . '" class="btn btn-primary text-white" onclick="modificar(this.id)">Modificar</a>
										<input id="btnGuardar' . $idSolicitud . '" type="hidden" class="btn btn-primary text-white" name="guardar" value="Guardar">
									</td>';
								
							echo'</form>';
						echo '</tr>';
					}
					echo '</table>';
				echo '</div>';
			}else{
				echo '<div class="row">';
					echo '<h5 class="float-left mb-3">Ninguna coincidencia</h5>';
				echo '</div>';
			}
			?>
				<a class="btn degradado-gris text-secondary float-right" href="panelDelAdministrador.php">Regresar</a>
		</div>
      </div>
    </div>
	
	<script>
		function modificar(id) {
			var idModificar = "btnGuardar".concat(id);
			var idEstatus = "estatus".concat(id);
			
			var btnModificar = document.getElementById(id);
			btnModificar.parentNode.removeChild(btnModificar)
			
			document.getElementById(idModificar).type = "submit";
			
			var estatus = document.getElementById(idEstatus);
			estatus.removeAttribute("readonly");
			estatus.focus();
			estatus.value = "";
		}
	</script>
	
	<!--Footer-->
    <?php require_once("footer/footer.php");?>
    <script src="scripts/jquery-3.3.1.min.js"></script>
    <script src="scripts/bootstrap.min.js"></script>
	<script src="scripts/sweetalert.min.js"></script>
	
  </body>
</html>

<?php
    if(isset($_SESSION['mensaje_exito'])){
	  $string = $_SESSION['mensaje_exito'];
	  echo "<script>
		swal('¡Exito!', ' ".$string."', 'success');
	  </script>";
	  //Deshacer la SESSION que contiene el mensaje actual
	  unset($_SESSION['mensaje_exito']);
	}
	if(isset($_SESSION['mensaje_error'])){
	  $string2 = $_SESSION['mensaje_error'];
	  echo "<script>
	    swal('¡Error!', ' ".$string2."', 'error');
	  </script>";
	  //Deshacer la SESSION que contiene el mensaje actual
	  unset($_SESSION['mensaje_error']);
    }
  }else{
    $_SESSION['mensaje_error'] = "Acceso Denegado";
    header('Location: index.php');
    exit();
  
  }
?>

