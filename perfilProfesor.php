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
	<title>Perfil del Profesor</title>
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
			  <h4>Datos del Profesor</h4>
			</center>
			
          </div>

          <div class="col-9 mx-auto border">
           
		   <form class="form mt-3" action="actualizarInfo.php" method="post" enctype='multipart/form-data'>
		   <?php
			$dirFotos = 'styles/img/profesores/';
		    $sql = "SELECT correo, telefono, biografia, area_investigacion, tesis, resumen, publicaciones, genero, foto FROM profesores
				WHERE id = '". $profesor['id'] . "'";
			
			$result = mysqli_query($mysqli, $sql);
			
			if (mysqli_num_rows($result) > 0) {
				while($row = mysqli_fetch_assoc($result)){
				$profesor['correo'] = $row['correo'];
				$profesor['telefono'] = $row['telefono'];
				$profesor['biografia'] = $row['biografia'];
				$profesor['area_investigacion'] = $row['area_investigacion'];
				$profesor['tesis'] = $row['tesis'];
				$profesor['resumen'] = $row['resumen'];
				$profesor['publicaciones'] = $row['publicaciones'];
				$profesor['genero'] = $row['genero'];
				$profesor['foto'] = $row['foto'];
				}
			}
			
			$areaSplit = explode("_", $profesor['area_investigacion']);
			$pubSplit = explode("_", $profesor['publicaciones']);
		   
		   echo '<div class="container p-0">';
			   echo '<div class="row">';
				   echo '<div id="contenedor" class="col pr-0 contenedor">';
						echo '<label for="subirFoto">';
							echo '<img id="foto" src="'. $dirFotos . $profesor['foto'] .'" class="fotoPerfil img-fluid mb-3">';
						echo '</label>';
						
						echo '<div class="mensaje">';
							echo '<label for="subirFoto" class="text-white text-center">Actualiza tu foto de perfil</label>';
						echo '</div>';
						
						echo '<input id="subirFoto" class="form-control-file border" type="file" name="foto" onchange="cambiarFoto(this)" hidden disabled/>';
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
		
			echo '<h5>Correo Electrónico</h5>';
			echo'<input id="correo" type="email" class="form-control form-control-lg mb-3" value="' . $profesor['correo'] . '" 
				placeholder="Correo Electrónico" name="correo" required="required" readonly>';
	
			echo '<div class="row">';
				echo '<div class="col">';
					echo '<h5>Teléfono</h5>';
					echo'<input id="telefono" type="text" class="form-control form-control-lg mb-3" value="' . $profesor['telefono'] . '"
						placeholder="Teléfono" name="telefono" required="required" pattern="[0-9]{10}" readonly>';
				echo '</div>';

				echo '<div class="col">';
					echo '<h5>Género</h5>';		
					echo '<select id="genero" class="form-control form-control-lg mb-3" name="genero" required="required" disabled>';
							if($profesor['genero'] == ""){
								echo '<option value="" selected disabled>Género</option>';
								echo '<option value="Masculino">Masculino</option>';
								echo '<option value="Femenino">Femenino</option>';
							}elseif($profesor['genero'] == "Masculino"){
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
			echo'<textarea id="biografia" rows="4" type="text" class="form-control form-control-lg mb-3" placeholder="Introduce un breve descripción acerca de tu formación académica" name="biografia" required="required" readonly>' . $profesor['biografia'] . '</textarea>';	
			
			echo '<div class="row">';
				echo '<div id="divA" class="col">';
					echo '<h5>Área de investigación</h5>';
					for($i = 0; $i < sizeof($areaSplit)-1; $i++){
						echo'<input id="inputa_' .$i. '" type="text" class="form-control form-control-lg mb-3" value="' . $areaSplit[$i] . '" placeholder="Area de investigación" name="areaInvestigacion[' . $i .']" required="required" readonly>';
					}
				echo '</div>';

				echo '<div class="col-md-auto" style="margin-top: 32px">';
					echo '<button id="fabutton" class="btn btn-lg mb-3 degradado-gris text-secondary font-weight-bold float-right" title="Nueva área de investigación" disabled>+</button>';
					echo '<a id="a_' . (sizeof($areaSplit)-2) . '" class="btn btn-lg mb-3 degradado-gris text-secondary font-weight-bold float-right" title="Nueva área de investigación" onclick="agregarA(this.id)" hidden>+</a>';
				echo '</div>';
			echo '</div>';
					
			echo '<div class="row">';
				echo '<div id="divP" class="col">';
					echo '<h5>Publicaciones</h5>';
					for($i = 0; $i < sizeof($pubSplit)-1; $i++){
						echo '<input id="inputp_' . $i . '" type="text" class="form-control form-control-lg mb-3" value="' . $pubSplit[$i] . '" placeholder="Publicación" name="publicaciones['. $i .']" required="required" readonly>';
					}
				echo '</div>';
				
				echo '<div class="col-md-auto" style="margin-top: 32px">';
					echo '<button id="fpbutton" class="btn btn-lg mb-3 degradado-gris text-secondary font-weight-bold float-right" title="Nueva publicación" disabled>+</button>';
					echo '<a id="p_' . (sizeof($pubSplit)-2) . '" class="btn btn-lg mb-3 degradado-gris text-secondary font-weight-bold float-right" title="Nueva publicación" onclick="agregarP(this.id)" hidden>+</a>';
				echo '</div>';
			echo '</div>';
			
				
			echo '<h5>Tesis</h5>';
			echo'<input id="tesis" type="text" class="form-control form-control-lg mb-3" value="' . $profesor['tesis'] . '" placeholder="Tesis" name="tesis" required="required" readonly>';
		
			echo '<h5>Resumen</h5>';	
			echo'<textarea id="resumen" rows="4" type="text" class="form-control form-control-lg mb-3"
				placeholder="Introduce una breve descripción del contenido de tu tesis" name="resumen" required="required" readonly>' . $profesor['resumen'] . '</textarea>';
				
			echo'<input id="actualizar" class="btn degradado-gris text-secondary my-3 mr-2" type="submit" name="actualizarInfoProfesor" value="Guardar" hidden>';
			echo '<a id="modificar" class="btn degradado-gris text-secondary my-3 mr-2" onclick="modificar()">Modificar mis datos</a>';
			echo '<a class="btn degradado-gris text-secondary my-3" href="contraseñaProfesor.php">Cambiar contraseña</a>';
			echo '<a class="btn degradado-gris text-secondary my-3 float-right" href="panelDelProfesor.php">Regresar</a>';
		   ?>
		   </form>
			
          </div>
        </div>
      </div>
    </div>
	
	<script>
		function modificar() {
			let sizeArea = parseInt("<?php echo sizeof($areaSplit) ?>") - 1;
			let sizePub = parseInt("<?php echo sizeof($pubSplit) ?>") - 1;
			document.getElementById("actualizar").hidden = false;
			document.getElementById("modificar").hidden = true;
			
			document.getElementById("subirFoto").removeAttribute("disabled");
			document.getElementById("correo").removeAttribute("readonly");
			document.getElementById("telefono").removeAttribute("readonly");
			document.getElementById("biografia").removeAttribute("readonly");
			document.getElementById("tesis").removeAttribute("readonly");
			document.getElementById("resumen").removeAttribute("readonly");
			
			for(let i = 0; i<sizeArea; i++){
				document.getElementById("inputa_".concat(i)).removeAttribute("readonly");
			}
			
			let fakebuttonA = document.getElementById("fabutton");
			fakebuttonA.parentNode.removeChild(fakebuttonA);
			document.getElementById("a_".concat(sizeArea-1)).hidden = false;
			
			for(let i = 0; i<sizePub; i++){
				document.getElementById("inputp_".concat(i)).removeAttribute("readonly");
			}
			
			let fakebuttonP = document.getElementById("fpbutton");
			fakebuttonP.parentNode.removeChild(fakebuttonP);
			document.getElementById("p_".concat(sizePub-1)).hidden = false;
			
			document.getElementById("genero").removeAttribute("disabled");

		}
		
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