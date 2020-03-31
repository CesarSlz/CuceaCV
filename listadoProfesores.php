<?php
	include('conectar.php');
	session_start();
	if(isset($_SESSION["admin"])){
	  $admin = $_SESSION["admin"];
?>

<!DOCTYPE html>
<html>
  <head>
	<title>Listado de Profesores</title>
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
		<h2 class="main-text mt-3">Profesores</h2>
      </center>
      
      <div class="row mx-5 mb-3 mt-1">

        <div class="col-12 mx-auto blueHeaders rounded my-3 border py-2">
          <center>
		    <h4>Consulta, modifica o elimina a los profesores registrados en el sistema </h4>
			
		  </center>
        </div>

        <div class="col-12 mx-auto p-0">
			<form class="form mt-3" action="usuariosOperaciones.php" method="post">
				<h5>Filtro</h5>
				<div class="row">
					
					<div class="col">
						<input class="form-control mt-1 mb-3" type="text" name="codigoP" placeholder="código de profesor" pattern="[0-9]{1,9}">
					</div>
					<div class="col">
						<select class="form-control mt-1 mb-3" name="estatus">
							<option value="" disabled selected>estatus</option>
							<option value="1">Activo</option>
							<option value="2">Inactivo</option>
						</select>
					</div>
					<div class="col-md-auto">
						<input class="btn degradado-gris text-secondary mt-1 mb-3 float-right" type="submit" name="buscarP" value="Buscar">
					</div>
				</div>
			</form>
			  
			<?php
			$urlCodigoP = mysqli_real_escape_string($mysqli, $_GET['codigo_profesor']);
			$urlEstatus = mysqli_real_escape_string($mysqli, $_GET['estatus']);
			
			$dirFotos = 'styles/img/profesores/';
			
			$sql = "SELECT id, codigo, nombre, apellido_pat, apellido_mat, estatus, foto FROM profesores";
				
			if(!empty($urlCodigoP) || !empty($urlEstatus)){
				$sql .= " WHERE";
				if(!empty($urlCodigoP)){
					$sql .= " codigo = '$urlCodigoP'";
				}
				if(!empty($urlEstatus)){
					if(!empty($urlCodigoP)){
						$sql .= " AND estatus = '$urlEstatus'";
					} else{
						$sql .= " estatus = '$urlEstatus'";
					}
				}
			}
			
			$sql .= " ORDER BY estatus ASC, nombre ASC";
			 
			$result = mysqli_query($mysqli, $sql);

			if (mysqli_num_rows($result) > 0) {
				
				echo '<div class="table-responsive">';
					echo '<table class="table table-hover border">';
							
					echo '<thead class="thead-light">';
						echo '<tr>';
							echo '<th>Fotografía</th>';
							echo '<th class="text-center">Código</th>';
							echo '<th class="text-center">Nombre</th>';
							echo '<th class="text-center">Estatus</th>';
							echo '<th class="text-center" colspan="2">Acciones</th>';
						echo '</tr>';
					echo '</thead>';
								
					while($row = mysqli_fetch_assoc($result)){
						$id = $row["id"];
						$codigo = $row["codigo"];
						$nombre = $row["nombre"];
						$apellidoPat = $row["apellido_pat"];
						$apellidoMat = $row["apellido_mat"];
						$estatus = $row["estatus"];
						$foto = $row["foto"];
						
						if($row["estatus"] == '1'){
							$estatus = "Activo";
						}else{
							$estatus = "Inactivo";
						}
									
						echo '<tr>';
							echo '<form action="usuariosOperaciones.php" method="post">';
								
								echo '<td style="width: 10%"><img class="fotoTabla" src="' . $dirFotos.$foto . '"></td>';
								echo '<td class="text-left align-middle">' . $codigo . '</td>';
								echo '<td class="text-left align-middle">' . $nombre . " " . $apellidoPat . " " . $apellidoMat . '</td>';
								echo '<td class="text-center align-middle" style="width: 15%">' . $estatus . '</td>';
								
								// input con los valores que sirver para manipular la informacion de las tablas en las base de datos
								echo '<input type="hidden" name="idProf" value="' . $id. '">';
								
								// input para conservar la url despues de hacer un cambio de estatus en las solicitudes
								echo '<input type="hidden" name="urlCodigoP" value="' . $urlCodigoP . '">';
								echo '<input type="hidden" name="urlEstatus" value="' . $urlEstatus . '">';
								
								echo '<td class="text-center align-middle" style="width: 10%">
										<a href="modificarProfesor.php?id=' . $id . '" class="btn btn-primary text-white">Modificar</a>
									</td>';
								
								echo '<td class="text-center align-middle" style="width: 10%">
										<input type="submit" class="btn btn-danger text-white" name="EliminarP" value="Eliminar">
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

