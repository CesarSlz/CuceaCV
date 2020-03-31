<?php
  ob_start();
  include('conectar.php');
  
  session_start();
  if(isset($_SESSION["admin"])){
	$admin = $_SESSION["admin"];
?>

<!DOCTYPE html>
<html>
  <head>
	<title>Modificar Estudiante</title>
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
		<h2 class="main-text mt-3">Modifica los datos del estudiante</h2>
      </center>
      
      <div class="row">

        <div class="row mx-auto mb-5 mt-1" >

          <div class="col-9 mx-auto blueHeaders rounded my-3 border py-2">

            <center>
			  <h4>Datos del Estudiantes</h4>
			</center>
			
          </div>

          <div class="col-9 mx-auto border">
           
		   <form class="form mt-3" action="usuariosOperaciones.php" method="post">
			
			<?php
				$urlId = mysqli_real_escape_string($mysqli, $_GET['id']);
				
				$sql = "SELECT a.id, a.id_posgrado, a.codigo, a.contraseña, a.nombre, a.apellido_pat, a.apellido_mat, a.correo, a.telefono, a.ciclo_ingreso, a.genero, a.estatus, p.carrera, p.sigla FROM alumnos a INNER JOIN posgrados p ON a.id_posgrado = p.id WHERE a.id = '$urlId'";
		 
				$result = mysqli_query($mysqli, $sql);
				
				if (mysqli_num_rows($result) > 0) {
					while($row = mysqli_fetch_assoc($result)){
						$id = $row["id"];
						$idPosgrado = $row["id_posgrado"];
						$codigo = $row["codigo"];
						$password = $row["contraseña"];
						$nombre = $row["nombre"];
						$apellidoPat = $row["apellido_pat"];
						$apellidoMat = $row["apellido_mat"];
						$correo = $row["correo"];
						$telefono = $row["telefono"];
						$cicloIngreso = $row["ciclo_ingreso"];
						$genero = $row["genero"];
						$estatus = $row["estatus"];
						$carrera = $row["carrera"];
						$sigla = $row["sigla"];
					}
				}
				
				echo '<h5>Código</h5>';
				echo'<input type="text" class="form-control form-control-lg mb-3" placeholder="Código" value="' . $codigo . '"
					name="codigo" pattern="[0-9]{1,9}">';
				
				echo '<div class="row">';
					echo '<div class="col">';
						echo '<h5>Nombre</h5>';
						echo '<input type="text" class="form-control form-control-lg mb-3" placeholder="Nombre"
						value="' . $nombre . '" name="nombre" pattern="^\b([A-z-Á-ú ]+\b)*$">';
					echo '</div>';
						
					echo '<div class="col">';
						echo '<h5>Apellido Paterno</h5>';
						echo '<input type="text" class="form-control form-control-lg mb-3" placeholder="Apellido Paterno"
						value="' . $apellidoPat . '" name="apellidoPat" pattern="^\b([A-z-Á-ú ]+\b)*$" >';
					echo '</div>';
						
					echo '<div class="col">';
						echo '<h5>Apellido Materno</h5>';
						echo'<input type="text" class="form-control form-control-lg mb-3" placeholder="Apellido Materno"
						value="' . $apellidoMat . '" name="apellidoMat" pattern="^\b([A-z-Á-ú ]+\b)*$"> ';
					echo '</div>';
				echo '</div>';
				
				echo '<h5>Carrera</h5>';
				echo '<select class="form-control form-control-lg mb-3" name="posgrado">
						<option value="" disabled>Coordinación</option>';
						$sql = "SELECT * FROM posgrados";
						$result = mysqli_query($mysqli, $sql);

						if (mysqli_num_rows($result) > 0) {
							
							while($row = mysqli_fetch_assoc($result)){
								$pId = $row['id'];
								$pSigla = $row['sigla'];
								$pCarrera = $row['carrera'];
								
								if($carrera == $pCarrera){
									echo '<option value="' . $pId . '" selected>' . $pCarrera . ' (' . $pSigla . ')' . '</option>';
								}else{
									echo '<option value="' . $pId . '">' . $pCarrera . ' (' . $pSigla . ')' . '</option>';
								}
							}
						}
				echo '</select>';
				
				echo '<div class="row">';
					echo '<div class="col">';
						echo '<h5>Ciclo Ingreso</h5>';
						echo '<select class="form-control form-control-lg mb-3" name="cicloIngreso">';
							echo '<option value="" disabled selected>Ciclo ingreso</option>';
							
							$fecha = date("Y-m-d");
						
							$fechaSplit = explode("-", $fecha);
						
							for($i = 2014; $i <= $fechaSplit[0]; $i++){
								if($i != $fechaSplit[0]){
									if($cicloIngreso == ($i . '10')){
										echo '<option value="' . $i . '10' . '" selected>' . $i . ' A' . '</option>';
										echo '<option value="' . $i . '20' . '">' . $i . ' B' . '</option>';
									}elseif($cicloIngreso == ($i . '20')){
										echo '<option value="' . $i . '10' . '">' . $i . ' A' . '</option>';
										echo '<option value="' . $i . '20' . '" selected>' . $i . ' B' . '</option>';
									}else{
										echo '<option value="' . $i . '10' . '">' . $i . ' A' . '</option>';
										echo '<option value="' . $i . '20' . '">' . $i . ' B' . '</option>';
									}
								}else{
									if($fechaSplit[1] < 8){
										if($cicloIngreso == ($i . '10')){
											echo '<option value="' . $i . '10' . '" selected>' . $i . ' A' . '</option>';
										}else{
											echo '<option value="' . $i . '10' . '">' . $i . ' A' . '</option>';
										}
									}
									else{
										if($cicloIngreso == ($i . '10')){
											echo '<option value="' . $i . '10' . '" selected>' . $i . ' A' . '</option>';
											echo '<option value="' . $i . '20' . '">' . $i . ' B' . '</option>';
										}elseif($cicloIngreso == ($i . '20')){
											echo '<option value="' . $i . '10' . '">' . $i . ' A' . '</option>';
											echo '<option value="' . $i . '20' . '" selected>' . $i . ' B' . '</option>';
										}else{
											echo '<option value="' . $i . '10' . '">' . $i . ' A' . '</option>';
											echo '<option value="' . $i . '20' . '">' . $i . ' B' . '</option>';
										}
									}
								}
							}
						echo '</select>';
					echo '</div>';
					
					echo '<div class="col">';
						echo '<h5>Constraseña</h5>';
						echo'<input type="text" class="form-control form-control-lg mb-3" placeholder="Constraseña"
						value="' . $password . '" name="contraseña" pattern="[A-z0-9]{8,30}">';
					echo '</div>';
				echo '</div>';
				
				echo '<div class="row">';
					echo '<div class="col">';
						echo '<h5>Correo Electrónico</h5>';
						echo'<input type="email" class="form-control form-control-lg mb-3" placeholder="Correo Electrónico"
						value="' . $correo . '" name="correo">';
					echo '</div>';
					
					echo '<div class="col">';
						echo '<h5>Teléfono</h5>';
						echo'<input type="text" class="form-control form-control-lg mb-3" placeholder="Teléfono" 
						value="' . $telefono . '" name="telefono" pattern="[0-9]{10}">';
					echo '</div>';
				echo '</div>';
				
				echo '<div class="row">';
					echo '<div class="col">';
						echo '<h5>Género</h5>';
						echo '<select class="form-control form-control-lg mb-3" name="genero">';
								if($genero == ""){
									echo '<option value="" selected disabled>Género</option>';
									echo '<option value="Masculino">Masculino</option>';
									echo '<option value="Femenino">Femenino</option>';
								}elseif($genero == "Masculino"){
									echo '<option value="" disabled>Género</option>';
									echo '<option value="Masculino" selected>Masculino</option>';
									echo '<option value="Femenino">Femenino</option>';
								}else{
									echo '<option value="" disabled>Género</option>';
									echo '<option value="Masculino">Masculino</option>';
									echo '<option value="Femenino" selected>Femenino</option>';
								}
						echo '</select>';
					echo '</div>';
					
					echo '<div class="col">';
						echo '<h5>Estatus</h5>';
						echo '<select class="form-control form-control-lg mb-3" name="estatus">
								<option value="" disabled>Estatus</option>';
								if($estatus == "1"){
									echo '<option value="1" selected>Activo</option>';
									echo '<option value="2">Inactivo</option>';
								}else{
									echo '<option value="1">Activo</option>';
									echo '<option value="2" selected>Inactivo</option>';
								}	
						echo '</select>';
					echo '</div>';
				echo '</div>';
				
				// input con los valores que sirver para manipular la informacion de las tablas en las base de datos
				echo '<input type="hidden" name="idAlum" value="' . $id. '">';
						
				echo'<input class="btn degradado-gris text-secondary my-3" type="submit"  name="ModificarA" value="Guardar">';
				echo '<a class="btn degradado-gris text-secondary my-3 float-right" href="listadoAlumnos.php">Regresar</a>';
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