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
	<title>Modificar Profesor</title>
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
			  <h4>Datos del Profesor</h4>
			</center>
			
          </div>

          <div class="col-9 mx-auto border">
           
		   <form class="form mt-3" action="usuariosOperaciones.php" method="post" enctype='multipart/form-data'>
		   <?php
			$urlId = mysqli_real_escape_string($mysqli, $_GET['id']);
			
			$dirFotos = 'styles/img/profesores/';
		    $sql = "SELECT * FROM profesores WHERE id = '$urlId'";
			
			$result = mysqli_query($mysqli, $sql);
			
			if (mysqli_num_rows($result) > 0) {
				while($row = mysqli_fetch_assoc($result)){
					$id = $row["id"];
					$codigo = $row["codigo"];
					$password = $row["contraseña"];
					$nombre = $row["nombre"];
					$apellidoPat = $row["apellido_pat"];
					$apellidoMat = $row["apellido_mat"];
					$correo = $row["correo"];
					$telefono = $row["telefono"];
					$biografia = $row["biografia"];
					$areaInvestigacion = $row["area_investigacion"];
					$tesis = $row["tesis"];
					$resumen = $row["resumen"];
					$publicaciones = $row["publicaciones"];
					$cupo = $row["cupo_alumnos"];
					$genero = $row["genero"];
					$estatus = $row["estatus"];
					$foto = $row["foto"];
				}
			}
			
			$areaSplit = explode("_", $areaInvestigacion);
			$pubSplit = explode("_", $publicaciones);
		   
		   echo '<div class="container p-0">';
			   echo '<div class="row">';
				   echo '<div id="contenedor" class="col pr-0 contenedor">';
						echo '<label for="subirFoto">';
							echo '<img id="foto" src="'. $dirFotos . $foto .'" class="fotoPerfil img-fluid mb-3">';
						echo '</label>';
						
						echo '<div class="mensaje">';
							echo '<label for="subirFoto" class="text-white text-center">Actualiza tu foto de perfil</label>';
						echo '</div>';
						
						echo '<input id="subirFoto" class="form-control-file border" type="file" name="foto" onchange="cambiarFoto(this)" hidden/>';
					echo '</div>';
				   
					echo '<div class="col-9">';
				   
					echo '<div class="row">';
						echo '<div class="col">';
							echo '<h5>Código</h5>';
							echo'<input type="text" class="form-control form-control-lg mb-3" placeholder="Código" 
							value="' . $codigo . '" name="codigo" pattern="[0-9]{1,9}">';
						echo '</div>';
					echo '</div>';
						
					echo '<div class="row">';
						echo '<div class="col">';
							echo '<h5>Nombre</h5>';
							echo '<input type="text" class="form-control form-control-lg mb-3" placeholder="Nombre"
							value="' . $nombre . '"name="nombre" pattern="^\b([A-z-Á-ú ]+\b)*$">';
						echo '</div>';
								
						echo '<div class="col">';
							echo '<h5>Apellido Paterno</h5>';
							echo '<input type="text" class="form-control form-control-lg mb-3" placeholder="Apellido Paterno"
							value="' . $apellidoPat . '" name="apellidoPat" pattern="^\b([A-z-Á-ú ]+\b)*$">';
						echo '</div>';
								
						echo '<div class="col">';
							echo '<h5>Apellido Materno</h5>';
							echo'<input type="text" class="form-control form-control-lg mb-3" placeholder="Apellido Materno"
							value="' . $apellidoMat . '" name="apellidoMat" pattern="^\b([A-z-Á-ú ]+\b)*$"> ';
						echo '</div>';
					echo '</div>';
					
					echo '</div>';
				echo '</div>';
			echo '</div>';
			
			echo '<div class="row">';
				echo '<div class="col">';
					echo '<h5>Correo Electrónico</h5>';
					echo'<input id="correo" type="email" class="form-control form-control-lg mb-3" value="' . $correo . '" 
					placeholder="Correo Electrónico" name="correo">';
				echo '</div>';
				
				echo '<div class="col">';
					echo '<h5>Constraseña</h5>';
					echo'<input type="text" class="form-control form-control-lg mb-3" placeholder="Constraseña"
					value="' . $password . '" name="contraseña" pattern="[A-z0-9]{8,30}">';
				echo '</div>';
			echo '</div>';
			
			echo '<div class="row">';
				echo '<div class="col">';
					echo '<h5>Teléfono</h5>';
					echo'<input id="telefono" type="text" class="form-control form-control-lg mb-3" value="' . $telefono . '"
						placeholder="Teléfono" name="telefono" pattern="[0-9]{10}">';
				echo '</div>';
				
				echo '<div class="col">';
					echo '<h5>Género</h5>';		
					echo '<select id="genero" class="form-control form-control-lg mb-3" name="genero">';
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
			echo '</div>';
			
			echo '<h5>Biografía</h5>';	
			echo'<textarea id="biografia" rows="4" type="text" class="form-control form-control-lg mb-3" placeholder="Introduce un breve descripción acerca de tu formación académica" name="biografia">' . $biografia . '</textarea>';	
			
			echo '<div class="row">';
				echo '<div id="divA" class="col">';
					echo '<h5>Área de investigación</h5>';
					for($i = 0; $i < sizeof($areaSplit)-1; $i++){
						echo'<input id="inputa_' .$i. '" type="text" class="form-control form-control-lg mb-3" value="' . $areaSplit[$i] . '" placeholder="Area de investigación" name="areaInvestigacion[' . $i .']">';
					}
				echo '</div>';

				echo '<div class="col-md-auto" style="margin-top: 32px">';
					echo '<a id="a_' . (sizeof($areaSplit)-2) . '" class="btn btn-lg mb-3 degradado-gris text-secondary font-weight-bold float-right" title="Nueva área de investigación" onclick="agregarA(this.id)">+</a>';
				echo '</div>';
			echo '</div>';
					
			echo '<div class="row">';
				echo '<div id="divP" class="col">';
					echo '<h5>Publicaciones</h5>';
					for($i = 0; $i < sizeof($pubSplit)-1; $i++){
						echo '<input id="inputp_' . $i . '" type="text" class="form-control form-control-lg mb-3" value="' . $pubSplit[$i] . '" placeholder="Publicación" name="publicaciones['. $i .']">';
					}
				echo '</div>';
				
				echo '<div class="col-md-auto" style="margin-top: 32px">';
					echo '<a id="p_' . (sizeof($pubSplit)-2) . '" class="btn btn-lg mb-3 degradado-gris text-secondary font-weight-bold float-right" title="Nueva publicación" onclick="agregarP(this.id)">+</a>';
				echo '</div>';
			echo '</div>';
			
				
			echo '<h5>Tesis</h5>';
			echo'<input id="tesis" type="text" class="form-control form-control-lg mb-3" value="' . $tesis . '" placeholder="Tesis" name="tesis">';
		
			echo '<h5>Resumen</h5>';	
			echo'<textarea id="resumen" rows="4" type="text" class="form-control form-control-lg mb-3"
				placeholder="Introduce una breve descripción del contenido de tu tesis" name="resumen">' . $resumen . '</textarea>';
				
			echo '<div class="row">';
				echo '<div class="col">';
					echo '<h5>Cupo de Alumnos</h5>';		
					echo'<input id="cupo" type="text" class="form-control form-control-lg mb-3" value="' . $cupo . '" placeholder="Cupo de Alumnos" name="cupo" pattern="[0-5]{1}">';
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
			echo '<input type="hidden" name="idProf" value="' . $id. '">';
			
			echo'<input class="btn degradado-gris text-secondary my-3" type="submit"  name="ModificarP" value="Guardar">';
			echo '<a class="btn degradado-gris text-secondary my-3 ml-2 float-right" href="listadoProfesores.php">Regresar</a>';
		   ?>
		   </form>
			
          </div>
        </div>
      </div>
    </div>
	
	<script>
		function agregarP(id) {
			let button = document.getElementById(id);
			let idSplit = button.id.split("_");
			let i = parseInt(idSplit[1]);
			i++;
			button.id = "p_".concat(i);
			
			let input = document.createElement("input");
			input.type = "text";
			input.classList.add("form-control", "form-control-lg", "mb-3");
			input.placeholder = "Nueva publicación";
			input.name = "publicaciones[".concat(i, "]");
			input.required = "required";
			
			let div = document.getElementById("divP");
			div.appendChild(input);
			
		}
		
		function agregarA(id) {
			let button = document.getElementById(id);
			let idSplit = button.id.split("_");
			let i = parseInt(idSplit[1]);
			i++;
			button.id = "a_".concat(i);
			
			let input = document.createElement("input");
			input.type = "text";
			input.classList.add("form-control", "form-control-lg", "mb-3");
			input.placeholder = "Nueva área de investigación";
			input.name = "areaInvestigacion[".concat(i, "]");
			input.required = "required";
			
			let div = document.getElementById("divA");
			div.appendChild(input);
		}
		
		function cambiarFoto(input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();

                reader.onload = function (e) {
                    $('#foto').attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
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
  ob_end_flush();
?>