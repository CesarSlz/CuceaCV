<?php
	include('conectar.php');
	session_start();
	
	if(isset($_POST['alumno'])){

		//Definir variable y Liberar de caracteres no deseados
	    $codigo = mysqli_real_escape_string($mysqli, $_POST['codigo']);
		$password = mysqli_real_escape_string($mysqli, $_POST['contraseña']);

	    //Comprobar que no tenga caracteres no deseados O que la variable no este vacia
	    if(empty($codigo) || empty($password) || !preg_match("/^[0-9]*$/", $codigo) || !preg_match("/^[A-z0-9]*$/", $password)){
	      $_SESSION['mensaje_error'] = "Datos con formato invalido";
	      header('Location: index.php');
	      exit();

	    }else{//Comprobar que el codigo exista en la base de datos		    
		    $sql = "SELECT * FROM alumnos WHERE codigo=? AND contraseña=?";
			
		    //Preparar la sentencia
		    $sentencia = mysqli_stmt_init($mysqli);
		
		    //Comprobar sentencia
		    if(!mysqli_stmt_prepare($sentencia, $sql)){
		       $_SESSION['mensaje_error'] = "Error al acceder";
		      	header('Location: index.php');
		      	exit();

		    }else{
		      //Ejecutar la sentencia preparada
		      mysqli_stmt_bind_param($sentencia, "ss", $codigo, $password);//Colocar variables en la sentencia sql
		      mysqli_stmt_execute($sentencia);//Ejecutar
		      mysqli_stmt_store_result($sentencia);//Almacenar resultado
		      $comprobarResultado = mysqli_stmt_num_rows($sentencia);//Guardar dato si al menos encontro una coincidencia

		     //Comprobar si el estudiante existe
		      if ($comprobarResultado > 0){		      
		      	//Asignar los datos del estudiante a un array en una $_SESSION
		      	$sentenciaEstudiante = mysqli_stmt_init($mysqli);

		        mysqli_stmt_prepare($sentenciaEstudiante, $sql);
		        mysqli_stmt_bind_param($sentenciaEstudiante, "ss", $codigo, $password);
		        mysqli_stmt_execute($sentenciaEstudiante);
		        $resultado = mysqli_stmt_get_result($sentenciaEstudiante);
		        $row = mysqli_fetch_assoc($resultado);		        
		        $_SESSION["alumno"]= $row;//Crear session con datos del estudiante

				if($_SESSION["alumno"]["correo"] != ""){
					header('Location: panelDelEstudiante.php');
					exit();

				}else {
					header('Location: actualizarAlumno.php');
					exit();
				}
		      }else{
		      	$_SESSION['mensaje_error'] = "Datos incorrectos";
		      	header('Location: index.php');
		      	exit();
		      }
		    }		     
	    }

	}else if(isset($_POST['profesor'])){
		//Eliminar caracteres especiales
		$codigo = mysqli_real_escape_string($mysqli, $_POST['codigo']);
		$password = mysqli_real_escape_string($mysqli, $_POST['contraseña']);

		//Comprobar que las variables no esten vacias o con caracteres no deseados
		if(empty($codigo) || empty($password) || !preg_match("/^[A-z0-9]*$/", $codigo) || !preg_match("/^[A-z0-9]*$/", $password)){
			$_SESSION['mensaje_error'] = "Datos con formato invalido";
		    header('Location: indexProfesores.php');
		    exit();

		}else{
		    $sql = "SELECT * FROM profesores WHERE codigo=? AND contraseña=?";

		    //Preparar la sentencia
		    $sentencia = mysqli_stmt_init($mysqli);
			
		    //Comprobar sentencia
		    if(!mysqli_stmt_prepare($sentencia, $sql)){
		       $_SESSION['mensaje_error'] = "Error al acceder";
		      	header('Location: indexProfesores.php');
		      	exit();

		    }else{
		      //Ejecutar la sentencia preparada
		      mysqli_stmt_bind_param($sentencia, "ss", $codigo, $password);//Colocar variables en la sentencia sql
		      mysqli_stmt_execute($sentencia);//Ejecutar
		      mysqli_stmt_store_result($sentencia);//Almacenar resultado
		      $comprobarResultado = mysqli_stmt_num_rows($sentencia);//Guardar dato si al menos encontro una coincidencia

		      //Comprobar si el profesor existe
		      if($comprobarResultado > 0){
		      	//Asignar los datos del profesor a un array en una $_SESSION
		      	$sentenciaProfesor = mysqli_stmt_init($mysqli);
		        mysqli_stmt_prepare($sentenciaProfesor, $sql);
		        mysqli_stmt_bind_param($sentenciaProfesor, "ss", $codigo, $password);
		        mysqli_stmt_execute($sentenciaProfesor);
		        $resultado = mysqli_stmt_get_result($sentenciaProfesor);
		        $row = mysqli_fetch_assoc($resultado);		       
		        $_SESSION["profesor"]= $row;//Crear session con datos del profesor

		        if($_SESSION["profesor"]["correo"] != ""){
					header('Location: panelDelProfesor.php');
					exit();
				}else {
					header('Location: actualizarProfesor.php');
					exit();
				}	        
		      }else{
		      	//*Comprobar si es administrador*
		      	$sql = "SELECT * FROM usuarios WHERE usuario=? AND contraseña=?";

			    //Preparar la sentencia
			    $sentencia = mysqli_stmt_init($mysqli);

			    //Comprobar sentencia
			    if(!mysqli_stmt_prepare($sentencia, $sql)){
			       $_SESSION['mensaje_error'] = "Error al acceder";
			      	header('Location: indexProfesores.php');
			      	exit();

			    }else{
			      //Ejecutar la sentencia preparada
			      mysqli_stmt_bind_param($sentencia, "ss", $codigo, $password);//Colocar variables en la sentencia sql
			      mysqli_stmt_execute($sentencia);//Ejecutar
			      mysqli_stmt_store_result($sentencia);//Almacenar resultado
			      $comprobarResultado = mysqli_stmt_num_rows($sentencia);//Guardar dato si al menos encontro una coincidencia

			      //Comprobar si el usuario existe
			      if ($comprobarResultado > 0){
			      	//Asignar los datos del usuario a un array en una $_SESSION
			      	$sentenciaProfesor = mysqli_stmt_init($mysqli);
			        mysqli_stmt_prepare($sentenciaProfesor, $sql);
			        mysqli_stmt_bind_param($sentenciaProfesor, "ss", $codigo, $password);
			        mysqli_stmt_execute($sentenciaProfesor);
			        $resultado = mysqli_stmt_get_result($sentenciaProfesor);
			        $row = mysqli_fetch_assoc($resultado);			       
			        $_SESSION["admin"]= $row;//Crear session con datos del admin
					
			        header('Location: panelDelAdministrador.php');
			        exit();

			      }else{
				      $_SESSION['mensaje_error'] = "Datos incorrectos";
				      header('Location: indexProfesores.php');
				      exit();
				  } 
				}
		      }	
			}
		}

	}else{
		$_SESSION['mensaje_error'] = "Acceso Denegado";
    	header('Location: index.php');
    	exit();
	}

?>