<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1,
      shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie-edge">
    <link rel="stylesheet" type="text/css" href="styles/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="styles/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="header/header.css">
    <title>Header</title>
  </head>
  <body>
    <div class="container">
      <div class="logo-udg">
        <img src="header/logo.jpg" alt="logo"/>
      </div>
    </div>
    <div class="container">
      <div class="row header">
        <h1 class="col-12 mx-auto font-header">CUCEA CV - Control de Vinculación </h1>
      </div>
    </div>
    <!-- Nav bar -->
    <?php if(!isset($_SESSION['alumno']) && !isset($_SESSION['profesor']) && !isset($_SESSION['admin'])){ ?>
      <div class="container border-right border-left my-2">
          <ul class="nav nav-justified justify-content-center ">
            <li class="nav-item  border border rounded">
              <a class="nav-link degradado-gris  text-secondary " href="index.php">Estudiantes</a>
            </li>
            <li class="nav-item border border rounded">
              <a class="nav-link degradado-gris  text-secondary " href="indexProfesores.php">Profesores</a>
            </li>
          </ul>
      </div>
    <?php 
      }
    ?>
  </body>
</html>

