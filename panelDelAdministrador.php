<?php 
  session_start();
  if(isset($_SESSION["admin"])){
	  $admin = $_SESSION["admin"];
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Panel del Administrador</title>
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
		  <h3>Panel del Administrador</h3>
          <p class="float-left my-3 font-weight-bold" ><?php echo "Administrador: " . $admin['usuario']; ?></p>
        </div>
		
		<div class="col">
          <a href="session_out.php" class="btn degradado-rojo text-white float-right mt-3">Cerrar sesión</a>
        </div>
		
      </div>
      <!-- CONTENIDO -->
      <div class="col mt-3 mb-5">
        
        <div class="card text-center">
            <div class="card-header">
              <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active text-dark"  id="home-tab" data-toggle="tab" href="#alumnos" role="tab" aria-controls="alumnos" aria-selected="true">Alumnos</a>
                </li>

                <li class="nav-item">
                  <a class="nav-link text-dark" id="home-tab" data-toggle="tab" href="#profesores" role="tab" aria-controls="profesores" aria-selected="true">Profesores</a>
                </li>

                <li class="nav-item">
                  <a class="nav-link text-dark" id="home-tab" data-toggle="tab" href="#solicitud" role="tab" aria-controls="solicitud" aria-selected="true">Solicitudes</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link text-dark" id="home-tab" data-toggle="tab" href="#administradores" role="tab" aria-controls="administradores" aria-selected="true">Administradores</a>
                </li>
              </ul>
            </div>

          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="alumnos" role="tabpanel" aria-labelledby="alumnos-tab">
              <div class="card-body">
                <h5 class="card-title">Alumnos</h5>
                <p class="card-text">Aquí puedes manipular la información de los Alumnos</p>
                <a href="registrarAlumno.php" class="btn btn-primary text-white ">Crear nuevo Alumno</a>
                <a href="listadoAlumnos.php" class="btn btn-primary text-white ">Listado de Alumnos</a>
              </div>
            </div>
			
            <div class="tab-pane fade show" id="profesores" role="tabpanel" aria-labelledby="profesores-tab">
              <div class="card-body">
                <h5 class="card-title">Profesores</h5>
                <p class="card-text">Aquí puedes manipular la información de los Profesores</p>
                <a href="registrarProfesor.php" class="btn btn-primary text-white ">Crear nuevo Profesor</a>
                <a href="listadoProfesores.php" class="btn btn-primary text-white ">Listado de Profesores</a>
              </div>
            </div>
			
            <div class="tab-pane fade show" id="solicitud" role="tabpanel" aria-labelledby="solicitud-tab">
			  <div class="card-body">
                <h5 class="card-title">Solicitudes</h5>
                <p class="card-text">Aquí puedes ver todas las solicitudes existentes y cambiar su estatus</p>
				<a href="solicitudesAdmin.php" class="btn btn-primary text-white">Solicitudes</a>
              </div>	
            </div>
			
            <div class="tab-pane fade show" id="administradores" role="tabpanel" aria-labelledby="administradores-tab">
              <div class="card-body">
                <h5 class="card-title">Administradores</h5>
                <p class="card-text">Aquí puedes manipular la información de los Administradores</p>
                <a href="registrarAdmin.php" class="btn btn-primary text-white ">Crear nuevo Administrador</a>
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
	  $string2 = $_SESSION['mensaje_error'];
	  echo "<script>
	    swal('¡Error!', ' ".$string2."', 'error');
	  </script>";
	  //Deshacer la SESSION que contiene el mensaje actual
	  unset($_SESSION['mensaje_error']);
    }
  }else{
    $_SESSION['mensaje_error'] = "Acceso Denegado";
    header('Location: index.php');
    exit();
  
  }
?>