<?php
  ob_start();
  include('conectar.php');
  
  session_start();
  if(isset($_SESSION["admin"])){
    $admin= $_SESSION["admin"];
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
		<h2 class="main-text mt-3">Registrar nuevo profesor</h2>
      </center>
      
      <div class="row">

        <div class="row mx-auto mb-5 mt-1" >

          <div class="col-9 mx-auto blueHeaders rounded my-3 border py-2">

            <center>
			  <h4>Proporciona la informacion requerida</h4>
			</center>
			
          </div>

          <div class="col-9 mx-auto border">
           
		   <form class="form mt-3" action="registrarInfo.php" method="post">
			
			  <h5>Código</h5>
			  <input type="text" class="form-control form-control-lg mb-3" name="codigo" required="required" pattern="[0-9]{1,9}" placeholder="Código">				
			  <div class="row">
			    <div class="col">
				  <h5>Nombre</h5>
				  <input type="text" class="form-control form-control-lg mb-3" name="nombre" required="required" pattern="^\b([A-z-Á-ú ]+\b)*$" 
					placeholder="Nombre">
				  </div>
						
				<div class="col">
				  <h5>Apellido Paterno</h5>
				  <input type="text" class="form-control form-control-lg mb-3" name="apellidoPat" required="required" pattern="^\b([A-z-Á-ú ]+\b)*$"
					placeholder="Apellido paterno">
				</div>
						
				<div class="col">
				  <h5>Apellido Materno</h5>
				  <input type="text" class="form-control form-control-lg mb-3" name="apellidoMat" required="required" pattern="^\b([A-z-Á-ú ]+\b)*$"
					placeholder="Apellido materno">
				</div>
			  </div>
				
			  <h5>Constraseña</h5>
			  <input type="password" class="form-control form-control-lg mb-3" name="contraseña" required="required" pattern="[A-z0-9]{8,30}"
				placeholder="Contraseña">
						
			  <input class="btn degradado-gris text-secondary my-3" type="submit" name="rProfesor" value="Guardar">
			  <a class="btn degradado-gris text-secondary my-3 ml-2 float-right" href="panelDelAdministrador.php">Regresar</a>
				
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
		swal('!Exito!', ' ".$string."', 'success');
	  </script>";
	  //Deshacer la SESSION que contiene el mensaje actual
	  unset($_SESSION['mensaje_exito']);
	}
	if(isset($_SESSION['mensaje_error'])){
	  $string = $_SESSION['mensaje_error'];
	  echo "<script>
		swal('!Error!', ' ".$string."', 'error');
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