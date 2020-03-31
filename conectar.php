<?php
	//Archivo de conexión php

	$mysqli = new mysqli("127.0.0.1:3307","root","admin","cuceacv");

	//Acentos y otros caracteres
	mysqli_set_charset($mysqli,'utf8');

  if (mysqli_connect_errno()){
    echo "Error al conectar con la base de datos: " . mysqli_connect_error();
  
}
?>
