<?php
    
    session_start();
    
    if(!isset($_SESSION['id'])){
        header("Location: index.php");
    }
    
    $nombre = $_SESSION['nombre'];
    $tipo_usuario = $_SESSION['tipo_usuario'];

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SOFT</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <style>
        .responsive {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body >
   	<?php
        include("../conexion.php");
	    $id = $_GET['id'];
	    if(isset($_GET['id']))
	    {
	       $sql = mysqli_query($mysqli, "SELECT * FROM usuarios WHERE id = '$id'");
	       $row = mysqli_fetch_array($sql);
        }
    ?>

   	<div class="container">
        <center>
            <img src='../img/logo.png' width="400" height="205" class="responsive">
        </center>
        <BR/>
        <h2><b>ACTUALIZAR INFORMACIÓN DEL USUARIO</b></h2>
        <p><i><b><font size=3 color=#c68615>*Datos obligatorios</i></b></font></p>
    
        <form action='adduser2.php' method='post'>
            
             <div class="form-row">
                <label>
                    <input type="text" name="id" hidden readonly value="<?php echo $row['id']; ?>">
                </label>
            </div>

            <div class="form-group">
                <label for="usuario">* USUARIO:</label>
                <input type='text' name='usuario' class='form-control' value='<?php echo $row['usuario']; ?>' required />
            </div>

            <div class="form-group">
                <label for="nombre">* NOMBRE DEL USUARIO:</label>
                <input type='text' name='nombre' class='form-control' value='<?php echo utf8_encode($row['nombre']); ?>' required />
            </div>

            <div class="form-group">
                <label for="tipo_usuario">* TIPO DE USUARIO:</label>
                <select class="form-control" name="tipo_usuario" required>
                    <option value=""></option>
                    <option value=1 <?php if($row['tipo_usuario']==1){echo 'selected';} ?>>Administrador</option>
                    <option value=2 <?php if($row['tipo_usuario']==2){echo 'selected';} ?>>Sistema</option>
                </select>
            </div>

            <button type="submit" class="btn btn-outline-warning" name="btn-update">
                <span class="spinner-border spinner-border-sm"></span>
                ACTUALIZAR INFORMACIÓN DEL USUARIO
            </button>
            <button type="reset" class="btn btn-outline-dark" role='link' onclick="history.back();" type='reset'><img src='../img/atras.png' width=27 height=27> REGRESAR
            </button>
        </form>
    </div>
</body>
</html>