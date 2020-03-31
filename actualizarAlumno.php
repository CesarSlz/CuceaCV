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
	<title>Registro del Estudiante</title>
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
		<h2 class="main-text mt-3">Por favor actualiza tus datos</h2>
      </center>
      
      <div class="row">

        <div class="row mx-auto mb-5 mt-1" >

          <div class="col-9 mx-auto blueHeaders rounded my-3 border py-2">

            <center>
			  <h4>Proporciona la información requerida</h4>
			</center>
			
          </div>

          <div class="col-9 mx-auto border">
           
		   <form class="form mt-3" action="actualizarInfo.php" method="post">
			
			<?php
				$sql = "SELECT alumnos.nombre, posgrados.sigla, posgrados.carrera FROM alumnos
				INNER JOIN posgrados ON alumnos.id_posgrado=posgrados.id WHERE alumnos.id = '". $alumno['id'] . "'";
		 
				$result = mysqli_query($mysqli, $sql);
				
				if (mysqli_num_rows($result) > 0) {
					while($row = mysqli_fetch_assoc($result)){
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
					name="posgrado" required="required" pattern="^\b([A-z-Á-ú ]+\b)*$" readonly>';
				
				echo '<div class="row">';
					echo '<div class="col">';
						echo '<h5>Correo Electrónico</h5>';
						echo'<input type="email" class="form-control form-control-lg mb-3" placeholder="Correo Electrónico"
							name="correo" required="required">';
					echo '</div>';
					
					echo '<div class="col">';
						echo '<h5>Teléfono</h5>';
						echo'<input type="text" class="form-control form-control-lg mb-3" placeholder="Teléfono" name="telefono"
							required="required" pattern="[0-9]{10}">';
					echo '</div>';
				echo '</div>';
				
				echo '<div class="row">';
					echo '<div class="col">';
						echo '<h5>Cambiar Constraseña</h5>';
						echo'<input type="password" class="form-control form-control-lg mb-3" placeholder="Constraseña"
							name="contraseña" required="required" pattern="[A-z0-9]{8,30}">';
					echo '</div>';
					
					echo '<div class="col">';
						echo '<h5>Género</h5>';
						echo'<select class="form-control form-control-lg mb-3" name="genero" required="required">
							<option value="" disabled selected>Género</option>
							<option value="Masculino">Masculino</option>
							<option value="Femenino">Femenino</option>
						</select>';
					echo '</div>';
				echo '</div>';
						
				echo'<input class="btn degradado-gris text-secondary my-3" type="submit"  name="actualizarRegistroAlumno" value="Guardar">';
			?>
				
			</form>
			
          </div>
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
	  $string = $_SESSION['mensaje_error'];
	  echo "<script>
		swal('¡Error!', ' ".$string."', 'error');
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