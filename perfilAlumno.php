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
	<title>Perfil del Estudiante</title>
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
		<h2 class="main-text mt-3">Mi perfil</h2>
      </center>
      
      <div class="row">

        <div class="row mx-auto mb-5 mt-1" >

          <div class="col-9 mx-auto blueHeaders rounded my-3 border py-2">

            <center>
			  <h4>Datos del Estudiante</h4>
			</center>
			
          </div>

          <div class="col-9 mx-auto border">
           
		   <form class="form mt-3" action="actualizarInfo.php" method="post">
			
			<?php
				$sql = "SELECT alumnos.correo, alumnos.telefono, alumnos.genero, posgrados.sigla, posgrados.carrera FROM alumnos
				INNER JOIN posgrados ON alumnos.id_posgrado=posgrados.id WHERE alumnos.id = '". $alumno['id'] . "'";
		 
				$result = mysqli_query($mysqli, $sql);
				
				if (mysqli_num_rows($result) > 0) {
					while($row = mysqli_fetch_assoc($result)){
					$alumno['correo'] = $row['correo'];
					$alumno['telefono'] = $row['telefono'];
					$alumno['genero'] = $row['genero'];
					$sigla = $row['sigla'];
					$carrera = $row['carrera'];
					}
				}
				
				echo '<h5>Código</h5>';
				echo'<input type="text" class="form-control form-control-lg mb-3" value="' . $alumno['codigo'] . '"
					name="codigo" required="required" pattern="[0-9]{1,9}" readonly>';
				
				echo '<div class="row">';
					echo '<div class="col">';
						echo '<h5>Nombre</h5>';
						echo '<input type="text" class="form-control form-control-lg mb-3" value="' . $alumno['nombre'] . '"
							name="nombre" required="required" pattern="^\b([A-z-Á-ú ]+\b)*$" readonly>';
					echo '</div>';
					
					echo '<div class="col">';
						echo '<h5>Apellido Paterno</h5>';
						echo '<input type="text" class="form-control form-control-lg mb-3" value="' . $alumno['apellido_pat'] . '"
							name="apellidoPat" required="required" pattern="^\b([A-z-Á-ú ]+\b)*$" readonly>';
					echo '</div>';
					
					echo '<div class="col">';
						echo '<h5>Apellido Materno</h5>';
						echo'<input type="text" class="form-control form-control-lg mb-3" value="' . $alumno['apellido_mat'] . '"
							name="apellidoMat" required="required" pattern="^\b([A-z-Á-ú ]+\b)*$" readonly> ';
					echo '</div>';
				echo '</div>';
				
				echo '<h5>Carrera</h5>';
				echo'<input type="text" class="form-control form-control-lg mb-3" value="' . $carrera . ' ('. $sigla .')'.'"
					name="posgrado" required="required" pattern="[A-z0-9]{8,30}" readonly>';
				
				echo '<div class="row">';
					echo '<div class="col">';
						echo '<h5>Correo Electrónico</h5>';
						echo'<input id="correo" type="email" class="form-control form-control-lg mb-3" placeholder="Ingresa tu correo electrónico"
							value="' . $alumno['correo'] . '" name="correo" required="required" readonly>';
					echo '</div>';
					
					echo '<div class="col">';
						echo '<h5>Teléfono</h5>';
						echo'<input id="telefono" type="text" class="form-control form-control-lg mb-3" placeholder="Ingresa tu teléfono"
							value="' . $alumno['telefono'] . '" name="telefono" required="required" pattern="[0-9]{10}" readonly>';
					echo '</div>';
				echo '</div>';
				
				echo '<h5>Género</h5>';
				echo '<select id="genero" class="form-control form-control-lg mb-3" name="genero" required="required" disabled>';
						if($alumno['genero'] == ""){
							echo '<option value="" selected disabled>Género</option>';
							echo '<option value="Masculino">Masculino</option>';
							echo '<option value="Femenino">Femenino</option>';
						}elseif($alumno['genero'] == "Masculino"){
							echo '<option value="" disabled>Género</option>';
							echo '<option value="Masculino" selected>Masculino</option>';
							echo '<option value="Femenino">Femenino</option>';
						}else{
							echo '<option value="" disabled>Género</option>';
							echo '<option value="Masculino">Masculino</option>';
							echo '<option value="Femenino" selected>Femenino</option>';
						}
				echo '</select>';
						
				echo '<input id="actualizar" class="btn degradado-gris text-secondary my-3 mr-2" type="submit" name="actualizarInfoAlumno" value="Guardar" hidden>';
				echo '<a id="modificar" class="btn degradado-gris text-secondary my-3 mr-2" onclick="modificar()">Modificar mis datos</a>';
				echo '<a class="btn degradado-gris text-secondary my-3" href="contraseñaAlumno.php">Cambiar contraseña</a>';
				echo '<a class="btn degradado-gris text-secondary my-3 float-right" href="panelDelEstudiante.php">Regresar</a>';
			?>
				
			</form>
			
          </div>
        </div>
      </div>
    </div>
	
	<script>
		function modificar() {
			document.getElementById("actualizar").hidden = false;
			document.getElementById("modificar").hidden = true;
			
			document.getElementById("correo").removeAttribute("readonly");
			document.getElementById("telefono").removeAttribute("readonly");
			document.getElementById("genero").removeAttribute("disabled");

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
  ob_end_flush();
?>