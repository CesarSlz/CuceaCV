<?php 

  ob_start();
  
  include('conectar.php');
  session_start();

  if(isset($_SESSION["profesor"])){
    $profesor = $_SESSION["profesor"];
?>
<!DOCTYPE html>
<html>
  <head>

	<title>Registro del Profesor</title>
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
			   <form class="form mt-3" action="actualizarInfo.php" method="post" enctype='multipart/form-data'>
			   
				<?php
				
				$dirFotos = 'styles/img/profesores/';
				
				echo '<div class="container p-0">';
				   echo '<div class="row">';
					   echo '<div id="contenedor" class="col pr-0 contenedor">';
							echo '<label for="subirFoto">';
								echo '<img id="foto" src="'. $dirFotos . $profesor['foto'] .'" class="fotoPerfil img-fluid mb-3">';
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
								echo'<input type="text" class="form-control form-control-lg mb-3" value="' . $profesor['codigo'] . '"
									name="codigo" required="required" pattern="[0-9]{1,9}" readonly>';
							echo '</div>';
						echo '</div>';
							
						echo '<div class="row">';
							echo '<div class="col">';
								echo '<h5>Nombre</h5>';
								echo '<input type="text" class="form-control form-control-lg mb-3" value="' . $profesor['nombre'] . '"
									name="nombre" required="required" pattern="^\b([A-z-Á-ú ]+\b)*$" readonly>';
							echo '</div>';
									
							echo '<div class="col">';
								echo '<h5>Apellido Paterno</h5>';
								echo '<input type="text" class="form-control form-control-lg mb-3" value="' . $profesor['apellido_pat'] . '"
									name="apellidoPat" required="required" pattern="^\b([A-z-Á-ú ]+\b)*$" readonly>';
							echo '</div>';
									
							echo '<div class="col">';
								echo '<h5>Apellido Materno</h5>';
								echo'<input type="text" class="form-control form-control-lg mb-3" value="' . $profesor['apellido_mat'] . '"
									name="apellidoMat" required="required" pattern="^\b([A-z-Á-ú ]+\b)*$" readonly> ';
							echo '</div>';
						echo '</div>';
						
						echo '</div>';
					echo '</div>';
				echo '</div>';
			
				echo '<div class="row">';
					echo '<div class="col">';
						echo '<h5>Correo Electrónico</h5>';
						echo'<input type="email" class="form-control form-control-lg mb-3" placeholder="Correo Electrónico"
							name="correo" required="required">';
					echo '</div>';

					echo '<div class="col">';
						echo '<h5>Teléfono</h5>';
						echo'<input type="text" class="form-control form-control-lg mb-3" placeholder="Teléfono"
							name="telefono" required="required" pattern="[0-9]{10}">';
					echo '</div>';
				echo '</div>';
					
				echo '<div class="row">';
					echo '<div class="col">';
						echo '<h5>Cambiar contraseña</h5>';
						echo'<input type="password" class="form-control form-control-lg mb-3" placeholder="Contraseña"
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
				
				echo '<h5>Biografía</h5>';	
				echo'<textarea rows="4" type="text" class="form-control form-control-lg mb-3"
					placeholder="Introduce un breve descripción acerca de tu formación académica" name="biografia" required="required"></textarea>';	
				
				echo '<div class="row">';
					echo '<div id="divA" class="col">';
						echo '<h5>Área de investigación</h5>';	
						echo'<input type="text" class="form-control form-control-lg mb-3" placeholder="Area de investigación" name="areaInvestigacion[0]" 		   required="required">';
					echo '</div>';

					echo '<div class="col-md-auto" style="margin-top: 32px">';
						echo '<a id="a_0" class="btn btn-lg mb-3 degradado-gris text-secondary font-weight-bold float-right" title="Nueva área de investigación" onclick="agregarA(this.id)">+</a>';
					echo '</div>';
				echo '</div>';
						
				echo '<div class="row">';
					echo '<div id="divP" class="col">';
						echo '<h5>Publicaciones</h5>';
						echo '<input type="text" class="form-control form-control-lg mb-3" placeholder="Publicación" name="publicaciones[0]" required="required">';
					echo '</div>';
					
					echo '<div class="col-md-auto" style="margin-top: 32px">';
						echo '<a id="p_0" class="btn btn-lg mb-3 degradado-gris text-secondary font-weight-bold float-right" title="Nueva publicación" onclick="agregarP(this.id)">+</a>';
					echo '</div>';
				echo '</div>';
				
				echo '<h5>Tesis</h5>';
				echo'<input type="text" class="form-control form-control-lg mb-3" placeholder="Tesis"name="tesis" required="required">';
			
				echo '<h5>Resumen</h5>';	
				echo'<textarea rows="4" type="text" class="form-control form-control-lg mb-3"
					placeholder="Introduce una breve descripción del contenido de tu tesis" name="resumen" required="required"></textarea>';
						
				echo'<input class="btn degradado-gris text-secondary my-3" type="submit" name="actualizarRegistroProfesor" value="Guardar">';
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