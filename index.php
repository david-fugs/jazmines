<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>SOFT</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src="js/popper.min.j"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <link href="fontawesome/css/all.css" rel="stylesheet"> <!--load all styles -->
		<style>
        	.responsive {
           		max-width: 100%;
            	height: auto;
        	}
    	</style>
    <head>
    <body>

		<center>
	    	<img src='img/logo.png' width="400" height="205" class="responsive">
		</center>
		<BR/>

<?php

	date_default_timezone_set("America/Bogota");
	include("conexion.php");

?>
		<div class="container">
			<h1><b><i class="fas fa-user-check"></i> CONSULTAR ESTADO DE CUENTA </b></h1>
			
			<form method="POST" action="index1.php">
				<div class="form-group">
	            	<div class="row">
	                	<div class="col-6 col-sm-6">
	                        <label for="num_doc_cta">NÚMERO DE DOCUMENTO DEL TITULAR</label>
	                        <i class="far fa-hand-point-down"></i>
	                        <input type='number' name='num_doc_cta' class='form-control' required />
	                	</div>
	           		</div>
	            </div>
			    
			    <button type="submit" class="btn btn-success">
					<span class="spinner-border spinner-border-sm"></span>REALIZAR CONSULTAR
				</button>
	  		</form>
	  		
	  		<p><h5>Desde nuestro Sitio Web puedes verificar el estado actual del contrato. Simplemente accede y con el número de documento del titular, podrás conocer el estado actual del plan y la cobertura vigente.
			<br /></h5></p>				
			<center>
				<br/><a href="https://exequialeslosjazmines.com/"><img src='img/atras.png' width="72" height="72" title="Regresar" /></a>
			</center>

	</body>
</html>