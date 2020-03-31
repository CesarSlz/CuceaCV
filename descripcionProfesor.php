<?php 
  ob_start();
  include('conectar.php');
  
  session_start();
  if(isset($_SESSION["alumno"])){
    $alumno = $_SESSION["alumno"];
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Descripción del Profesor</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie-edge">
    <link rel="stylesheet" type="text/css" href="styles/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="styles/css/estilo.css">
  </head>
  <body onload="deshabilitar()">
    <!-- Header -->
    <?php include("header/header.php"); ?>
    <!-- Contenido -->
    
    <div class="container border">
      <div class="row">
        <div class="col-12">
          <p class="float-left mt-3 font-weight-bold " ><?php echo "Codigo: ".$alumno['codigo']; ?></p>
		  
          <a href="session_out.php" class="btn degradado-rojo text-white float-right mt-3 ml-1">Cerrar sesión</a>
		  <a href="perfilAlumno.php" class="btn degradado-azulMarino text-white  float-right mt-3">Mi perfil</a>

        </div>
        <div class="col-12">
          <p class="float-left mb-3 font-weight-bold" ><?php echo "Estudiante: ". $alumno['nombre'] . " " . $alumno['apellido_pat'] . " " . $alumno['apellido_mat']; ?></p>
        </div>
      </div>
      <!--CONTENIDO -->
      <div class="col mt-3 mb-5">
        
        <div class="card text-center">
            <div class="card-header">
              <ul class="nav nav-tabs card-header-tabs float-right">
                <li class="nav-item">
                  <a class="nav-link text-dark font-weight-bold" href="panelDelEstudiante.php">Regresar</a>
                </li>
              </ul>
            </div>
			

          <div class="tab-content">
            <div class="tab-pane fade show active">	
				<div class="card-body">
					<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $_GET['id'];?>" method="post">
				
					<?php
					
					$idProf = mysqli_real_escape_string($mysqli, $_GET['id']);
					$dirFotos = 'styles/img/profesores/';
					
					$sql = "SELECT * FROM profesores WHERE id = '$idProf'"; 
					
					$result = mysqli_query($mysqli, $sql);
					
					if (mysqli_num_rows($result) > 0) {
						
						while($row = mysqli_fetch_assoc($result)){
					
							$nombre = $row["nombre"];
							$apellidoPat = $row["apellido_pat"];
							$apellidoMat = $row["apellido_mat"];
							$correo = $row["correo"];
							$telefono = $row["telefono"];
							$biografia = $row["biografia"];
							$area = $row["area_investigacion"];
							$tesis = $row["tesis"];
							$resumen = $row["resumen"];
							$publicaciones = $row["publicaciones"];
							$cupoAlumnos = $row["cupo_alumnos"];
							$foto = $row["foto"];
							
							$publicacionesSplit = explode("_", $publicaciones);
							$areaSplit = explode("_", $area);
							
							echo '<h4 class="text-left text-secondary mb-3">
									<b>' . $nombre . " " . $apellidoPat . " " . $apellidoMat . '</b></h4>';
							
							echo '<div class="container colorFondo">';
								echo '<div class="row">';
									
									echo '<div class="col-3 px-0">';
										echo '<img class="fotoDesc my-3" src="' .$dirFotos.$foto. '">';
									echo '</div>';
									
									echo '<div class="col-9 pl-0">';
										echo '<div class="row">';
										
											echo '<div class="col mt-3">';
												echo '<p class="text-left text-white"><b>Correo electrónico: </b>' . $correo . '</p>';
												echo '<p class="text-left text-white"><b>Teléfono: </b>' . $telefono . '</p>';
												echo '<p class="text-left text-white"><b>Cupo: </b>' . $cupoAlumnos . "/5" . '</p>';
											echo '</div>';
											
											echo '<div class="col mt-3">';
												echo '<input type="hidden" name="idProfesor" value="' . $idProf . '">';
												echo '<input id="btnValidar" class="btn degradado-gris text-secondary float-right my-2" type="submit" name="vincular" 
												value="Vincularse con profesor">';
											echo '</div>';
									
										echo '</div>';
										
										echo '<h5 class="text-left text-white mt-3"><b>Biografía: </b></h5>';
										echo '<p class="text-justify text-white">' . $biografia . '</p>';
									echo '</div>';
								echo '</div>';
							echo '</div>';
							
							echo '<div class="container mt-3">';
							
								echo '<h5 class="text-left text-secondary"><b>Tesis: </b></h5>';
								echo '<p class="text-justify ml-2"><b>Título: </b>' . $tesis . '</p>';
								echo '<p class="text-justify ml-2"><b>Resumen: </b>' . $resumen . '</p>';
								
								echo '<h5 class="text-left text-secondary"><b>Áreas de investigación: </b></h5>';
								echo '<ul>';
									for($i = 0; $i < sizeof($areaSplit)-1; $i++){
										echo '<li><p class="text-justify">' . $areaSplit[$i] . '</p></li>';
									}
								echo '</ul>';
								
								echo '<h5 class="text-left text-secondary"><b>Publicaciones: </b></h5>';
								
								echo '<ul>';
									for($i = 0; $i < sizeof($publicacionesSplit)-1; $i++){
										echo '<li><p class="text-justify">' . $publicacionesSplit[$i] . '</p></li>';
									}
								echo '</ul>';
									
							echo '</div>';
						}
					}
					
					// Codigo para verificar si la solicitud ya ha sido envidia y poder bloquer boton
					$idAlum = $alumno['id'];
					$sql_check = "SELECT * FROM solicitudes WHERE id_alumno = '$idAlum' AND id_profesor = '$idProf'";
					
					$result = mysqli_query($mysqli, $sql_check);
					
					if (mysqli_num_rows($result) > 0) {
						$fuePresionado = 1;
					}else{
						$fuePresionado = 0;
					}
					?>
					
					</form>
					
				
					
				</div>
            </div>
          </div>
        </div>
      </div>
    </div>
	
	<script>
		function deshabilitar() {
			var fuePresionado = "<?php echo $fuePresionado ?>"; 
			var cupo = "<?php echo $cupoAlumnos ?>";
			
			if(fuePresionado == 1 || cupo >= 5){
				document.getElementById("btnValidar").disabled = true;
			}else{
				document.getElementById("btnValidar").disabled = false;
			}
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
    $_SESSION['mensaje_error'] = "Por favor ingrese con su codigo";
    header('Location: index.php');
    exit();
  }
  
  if(isset($_POST['vincular'])){
	$idProfesor = mysqli_real_escape_string($mysqli, $_POST['idProfesor']);
	$idAlumno = $alumno['id'];
	
	date_default_timezone_set("America/Mexico_City");
	$fecha = date("Y-m-d");
						
	$sql_vinc = "INSERT INTO solicitudes(id_alumno, id_profesor, fecha) VALUES('$idAlumno', '$idProfesor', '$fecha')";
						
	if (mysqli_query($mysqli, $sql_vinc)) {
		$_SESSION['mensaje_exito'] = "Exito en realizar la solicitud";
		header('Location: descripcionProfesor.php?id=' . $idProfesor);
	}else {
		$_SESSION['mensaje_error'] = "Error en realizar la solicitud";
		header('Location: descripcionProfesor.php?id=' . $idProfesor);
	}		
  }
  
  ob_end_flush();
?>