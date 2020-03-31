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
	<title>Registro del Administrador</title>
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
		<h2 class="main-text mt-3">Registrar nuevo administrador</h2>
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
			
			  <h5>Usuario</h5>
			  <input type="text" class="form-control form-control-lg mb-3" name="usuario" required="required" pattern="[A-z]{1,15}" placeholder="Usuario">				
				
			  <h5>Constraseña</h5>
			  <input type="password" class="form-control form-control-lg mb-3" name="contraseña" required="required" pattern="[A-z0-9]{1,15}"
				placeholder="Contraseña">
				
			  <h5>Coordinación</h5>
			  <select class="form-control form-control-lg mb-3" name="coordinacion" required="required">
				<option value="" disabled selected>Coordinación</option>
				<?php
					$sql = "SELECT * FROM posgrados";
					$result = mysqli_query($mysqli, $sql);

					if (mysqli_num_rows($result) > 0) {
						
						while($row = mysqli_fetch_assoc($result)){
							$id = $row['id'];
							$sigla = $row['sigla'];
							$carrera = $row['carrera'];
							
							echo '<option value="' . $id . '">' . $carrera . ' (' . $sigla . ')' . '</option>';
						}
					}
				?>
				
			  </select>
						
			  <input class="btn degradado-gris text-secondary my-3" type="submit" name="rAdmin" value="Guardar">
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