<?php

$conexion = new mysqli("localhost", "aprendad_jazsoft", "jazsoft123*", "aprendad_exejazmsoft");
	
	if($conexion->connect_error){
		
		die('Error en la conexion' . $conexion->connect_error);
		
	}

?>