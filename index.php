<?php 
  session_start();
  if(isset($_SESSION["alumno"])){
  	header('Location: panelDelEstudiante.php');
  }elseif(isset($_SESSION["profesor"])) {
  	header('Location: panelDelProfesor.php');
  }elseif(isset($_SESSION["admin"])) {
  	header('Location: panelDelAdministrador.php');
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Inicio</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie-edge">
    <link rel="stylesheet" type="text/css" href="styles/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="styles/css/estilo.css">
  </head>
  <body>
    <!-- Header -->
    <?php include("header/header.php"); ?>

    <!-- Contenido -->
    <div class="container border-right border-left">
      
	  <center>
		<h2 class="main-text ">Vinculación con Directores de Tesis</h2>
      </center>

      <div class="row ">

        <div class="row mx-auto mb-5 mt-1" >

          <div class="col-12 blueHeaders rounded my-3 border py-2">

			<center>
				<h4>Ingresar como Estudiante</h4>
			</center>
			
          </div>
		  
          <div class="col-12 border">
            
            <form class="form mt-3" action="login.php" method="post">
              <input class="form-control form-control-lg my-3" name="codigo" placeholder="Código" required="required" pattern="[0-9]{1,9}">
			  <input type="password" class="form-control form-control-lg my-3" name="contraseña" placeholder="Contraseña" required="required" pattern="[A-z0-9]{1,30}">
			  
              <input class="btn degradado-gris text-secondary my-3" type="submit"  name="alumno" value="Iniciar Sesión"  >
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
    
    <!-- Mensaje de alerta -->
    <?php 
    if(isset($_SESSION['mensaje_error'])){
    	$string = $_SESSION['mensaje_error'];
    	echo "<script>
      			swal('¡Error!', ' ".$string."', 'error');
		      </script>";
		    //Deshacer la SESSION que contiene el mensaje actual
    	unset($_SESSION['mensaje_error']);
	}
    ?>
	
  </body>
</html>
