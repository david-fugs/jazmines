<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>SOFT</title>
	<link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Orbitron" rel="stylesheet">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/tablas.css">
	<script src="jquery-3.1.1.js"></script>
	<script src="main.js"></script>
	<link href="fontawesome/css/all.css" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	<style>
		.responsive {
			max-width: 100%;
			height: auto;
		}

		.table td,
		.table th {
			text-align: center;
			vertical-align: middle;
			/* Para centrar verticalmente */
		}
	</style>

	<head>

	<body>

		<center>
			<img src='img/logo.png' width="350" height="180" class="responsive">
			<br />
			<hr>
			<h3><b><i class="fas fa-calculator"></i> ESTADO DE CUENTA ACTUAL </b></h3>
			<hr><br>
		</center>
		<?php

		date_default_timezone_set("America/Bogota");
		setlocale(LC_MONETARY, 'es_CO');
		include("conexion.php");

		$num_doc_cta = $_POST['num_doc_cta'];

		$consulta = "SELECT * FROM cuenta WHERE num_doc_cta='$num_doc_cta' AND estado_cta=1";
		$res = mysqli_query($mysqli, $consulta);
		$num_reg = mysqli_num_rows($res);
		if ($num_reg > 0) {
			echo "
			<div class='container '>
				<div class='text-center'>
					<h3 style='font-size: 24px; font-weight: bold; color: #333;'>NÚMERO DE DOCUMENTO DEL TITULAR: 
						<b><u>" . $num_doc_cta . "</b></u>
					</h3>
				</div>
				<div class='table-responsive m-5'>
					<table class='table table-bordered'>
						<thead class='thead-dark text-center' style='font-size: 20px; font-family: Arial, sans-serif;'>
							<tr>
								<th>No. OFERTA</th>
								<th>NOMBRES</th>
								<th>APELLIDOS</th>
								<th>TIPO DE PLAN</th>
								<th>COBERTURA</th>
								<th>No. BENEFICIARIOS</th>
								<th>CUOTA</th>
								<th>PAGAR</th>
							</tr>
						</thead>
						<tbody class='text-center' style='font-size: 18px; font-family: Arial, sans-serif;'>
			";
			$i = 1;
			while ($i <= $num_reg) {
				$f = mysqli_fetch_array($res);
				echo "<td style='text-align: center;'>" . $f['num_ofe_cta'] . "</td>";
				echo "<td style='text-align: center;'>" . $f['nom_cta'] . "</td>";
				echo "<td style='text-align: center;'>" . $f['ape_cta'] . "</td>";
				echo "<td style='text-align: center;'>" . $f['plan_cta'] . "</td>";
				echo "<td style='text-align: center;'>" . $f['cob_cta'] . "</td>";
				echo "<td style='text-align: center;'>" . $f['ctd_ben_cta'] . "</td>";
				echo "<td style='text-align: center;'>$" . number_format($f['vlr_cuo_cta'], 2, ',', '.') . "</td>";


				echo "<td>
						<a href='https://exequialeslosjazmines.com/' class=''>
							<img src='img/PSE2.png' width='40' height='40' class='mr-2'> 
						</a>
					  </td>";

				echo "</tr>";
				$i++;
			}

			echo "
						</tbody>
					</table>
				</div>
			</div>";

			echo "
			<div class='table-title'></div>
			<br> 
			<div style='margin-top:55px;' >
			<center>
				<img src='img/Anuncio1.png' class='responsive'>
				<img src='img/Anuncio2.png' class='responsive'>
				<br><br>
				<h5><b>Si desea mayor información sobre el plan, acércate a nuestras oficinas o comunícate a los siguientes números: +57 (606) 3641265 - 3642205</b></h5>
			</center>
			<div>
			";
		} else {
			echo "
			<div class='table-title'>
				<center><h5><b>NO SE ENCUENTRA NINGÚN TITULAR RELACIONADO A ESTE NÚMERO DE DOCUMENTO: <u>" . $num_doc_cta . "</b></u></h5></center>
			</div>";
		}

		mysqli_close($mysqli);
		?>

		<center>
			<br />
			<a href="javascript:history.back();">
				<img src="img/atras.png" width="72" height="72" title="Regresar" />
			</a>
		</center>