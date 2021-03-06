<?php 
  ob_start();
  
  session_start();
  if(isset($_SESSION["profesor"])){
    $profesor = $_SESSION["profesor"];
	
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Panel del Profesor</title>
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
    
    <div class="container border">
      <div class="row">
        <div class="col my-3">
		  <h3>Panel del profesor</h3>
		  <p class="mt-3 font-weight-bold"><?php echo "Código: " . $profesor['codigo'];?></p>
          <p class="mb-3 font-weight-bold"><?php echo "Profesor: " . $profesor['nombre'] . " " . $profesor['apellido_pat'] . " " . $profesor['apellido_mat'];?></p>

        </div>
        
        <div class="col">
		  <a href="session_out.php" class="btn degradado-rojo text-white float-right mt-3">Cerrar sesión</a>
		  <a href="perfilProfesor.php" class="btn degradado-azulMarino text-white float-right mt-3 mr-1">Mi perfil</a>
		  
        </div>
      </div>
      <!--CONTENIDO -->
      <div class="col mt-3 mb-5">
        
        <div class="card text-center">
            <div class="card-header">
              <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active text-dark" id="home-tab" data-toggle="tab" href="#alumnos" role="tab" aria-controls="alumnos" aria-selected="true">Alumnos</a>
                </li>
				
				<li class="nav-item">
                  <a class="nav-link text-dark" id="home-tab" data-toggle="tab" href="#solicitud" role="tab" aria-controls="solicitud" aria-selected="true">Solicitudes</a>
                </li>

              </ul>
            </div>

          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="alumnos" role="tabpanel" aria-labelledby="alumnos-tab">
              <div class="card-body">
				<?php include('solicitudesProfesorAceptadas.php'); ?>
              </div>
            </div>

            <div class="tab-pane fade show " id="solicitud" role="tabpanel" aria-labelledby="solicitud-tab">
              <div class="card-body">
				<?php include('solicitudesProfesorPendientes.php'); ?>
              </div>
            </div>

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
    $_SESSION['mensaje_error'] = "Acceso denegado";
    header('Location: index.php');
    exit();
  }
  
  ob_end_flush();
?>