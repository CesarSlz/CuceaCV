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

          <div class="col-12 blueHeaders rounded my-3 border py-2">

            <center>
			  <h4>Cambia tu contraseña</h4>
			</center>
			
          </div>

          <div class="col-12 border">
           
		   <form class="form mt-3" action="cambiarContraseña.php" method="post">
			
			<?php
				echo '<h5>Constraseña actual</h5>';
				echo'<input type="password" class="form-control form-control-lg mb-3" placeholder="Ingresa tu contraseña actual"
					name="contraActual" required="required" pattern="[A-z0-9]{8,30}">';
				
				echo '<h5>Nueva contraseña</h5>';
				echo'<input type="password" class="form-control form-control-lg mb-3" placeholder="Ingresa la contraseña nueva"
					name="contraNueva" required="required" pattern="[A-z0-9]{8,30}">';
				
				echo '<h5>Confirmar constraseña</h5>';
				echo'<input type="password" class="form-control form-control-lg mb-3" placeholder="Vuelve a ingresar la contraseña"
					name="contraConfirm" required="required" pattern="[A-z0-9]{8,30}">';
				
						
				echo'<input class="btn degradado-gris text-secondary my-3" type="submit" name="cambiarContraAlumno" value="Cambiar contraseña">';
				echo '<a class="btn degradado-gris text-secondary my-3 ml-2 float-right" href="perfilAlumno.php">Regresar</a>';
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