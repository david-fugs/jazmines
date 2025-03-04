<?php
session_start();
include("../../conexion.php");
if (!isset($_SESSION['id'])) {
    header("Location: ../../index.php");
}



$nombre = $_SESSION['nombre'];
$tipo_usu = $_SESSION['tipo_usuario'];

if (isset($_GET['delete'])) {
    $num_doc_cta = $_GET['delete'];
    deleteMember($num_doc_cta);
}

function deleteMember($num_ofe_cta)
{
    global $mysqli; // Asegurar acceso a la conexión global

    $query = "DELETE FROM cuenta WHERE num_ofe_cta = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $num_ofe_cta);

    if ($stmt->execute()) {
        echo "<script>alert('Cuenta eliminada correctamente');
        window.location = 'showClients.php';</script>";
    } else {
        echo "<script>alert('Error al eliminar el Cuenta');
        window.location = 'showClients.php';</script>";
    }

    $stmt->close();
}
function getStatus($estado)
{
    if ($estado == 1) {
        return "<span class='badge bg-success'>ACTIVO</span>";
    } else {
        return "<span class='badge bg-danger'>INACTIVO</span>";
    }
}

// Obtener los filtros desde el formulario
$cuenta = isset($_GET['num_ofe_cta']) ? trim($_GET['num_ofe_cta']) : '';
$cc = isset($_GET['num_doc_cta']) ? trim($_GET['num_doc_cta']) : '';
$nombre = isset($_GET['nom_cta']) ? trim($_GET['nom_cta']) : '';
$plan = isset($_GET['plan_cta']) ? trim($_GET['plan_cta']) : '';
$estado = isset($_GET['estado']) ? trim($_GET['estado']) : '';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CT | SOFT</title>
    <script src="js/64d58efce2.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Orbitron" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <link rel="stylesheet" type="text/css" href="../css/estilos2024.css">
    <link href="../../../fontawesome/css/all.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/fed2435e21.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


    <style>
        th {
            font-size: 15px;
        }

        td {
            font-size: 15px;
        }

        .responsive {
            max-width: 100%;
            height: auto;
        }

        .selector-for-some-widget {
            box-sizing: content-box;
        }

        .pending {
            background-color: orange;
            color: white;
            font-weight: bold;
            text-align: center;
        }

        .ok {
            background-color: lightblue;
            color: black;
            font-weight: bold;
            text-align: center;
        }

        .disabled-link {
            pointer-events: none;
            opacity: 0.6;
        }
    </style>
</head>

<body>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"></script>

    <center style="margin-top: 20px;">
        <img src='../../img/logo.png' width="300" height="212" class="responsive">
    </center>

    <h1 style="color: #412fd1; text-shadow: #FFFFFF 0.1em 0.1em 0.2em; font-size: 40px; text-align: center;"><b><i class="fa-solid fa-file-signature"></i> CUENTAS</b></h1>

    <div class="flex">
        <div class="box">
            <form action="showClients.php" method="get" class="form">
                <input name="num_ofe_cta" type="text" placeholder="Cuenta Cliente" value="<?= htmlspecialchars($cuenta) ?>">
                <input name="num_doc_cta" type="text" placeholder="Cedula Cliente" value="<?= htmlspecialchars($cc) ?>">
                <input name="nom_cta" type="text" placeholder="Nombre Cliente" value="<?= htmlspecialchars($nombre) ?>">
                <input name="plan_cta" type="text" placeholder="Plan Cliente" value="<?= htmlspecialchars($plan) ?>">
                <select name="estado">
                    <option value="" <?= ($estado == '') ? 'selected' : '' ?> >Seleccione un estado</option>
                    <option value="1" <?= ($estado == '1') ? 'selected' : '' ?>>Activo</option>
                    <option value="0" <?= ($estado == '0') ? 'selected' : '' ?>>Inactivo</option>
                </select>
                <input value="Realizar Busqueda" type="submit">
            </form>
        </div>
    </div>
    <br /><a href="../access.php"><img src='../img/atras.png' width="72" height="72" title="Regresar" /></a><br>
    <?php
    date_default_timezone_set("America/Bogota");
    include("../../conexion.php");
    require_once("../../zebra.php");

    // Inicializa la consulta base
    $queryBase = "SELECT * FROM cuenta WHERE 1=1";

    // Agrega filtros si existen


    if (!empty($_GET['plan_cta'])) {
        $plan_cta = $mysqli->real_escape_string($_GET['plan_cta']);
        $queryBase .= " AND plan_cta LIKE '%$plan%'";
    }
    if (!empty($_GET['num_ofe_cta'])) {
        $num_ofe_cta = $mysqli->real_escape_string($_GET['num_ofe_cta']);
        $queryBase .= " AND num_ofe_cta = '$num_ofe_cta'";
    }
    if ($_GET['estado'] != "") {
        $estado = $mysqli->real_escape_string($_GET['estado']);
        $queryBase .= " AND estado_cta = '$estado' ";
    }
    if (!empty($_GET['num_doc_cta'])) {
        $num_doc_cta = $mysqli->real_escape_string($_GET['num_doc_cta']);
        $queryBase .= " AND num_doc_cta = '$num_doc_cta'";
    }

    if (!empty($_GET['nom_cta'])) {
        $nom_cta = $mysqli->real_escape_string($_GET['nom_cta']);
        $queryBase .= " AND nom_cta LIKE '%$nom_cta%'";
    }

    // Contar total de registros antes de aplicar el LIMIT
    $res = $mysqli->query($queryBase);
    if (!$res) {
        die("Error en la consulta: " . $mysqli->error);
    }
    $num_registros = mysqli_num_rows($res);
    $resul_x_pagina = 50;
    // Configuración de Zebra_Pagination
    $paginacion = new Zebra_Pagination();
    $paginacion->records($num_registros);
    $paginacion->records_per_page($resul_x_pagina);

    $page = $paginacion->get_page(); // Obtiene la página actual
    $offset = ($page - 1) * $resul_x_pagina; // Calcula el desplazamiento


    $queryFinal = $queryBase . "  LIMIT $offset, $resul_x_pagina";
    // Ejecutar consulta con paginación
    $result = $mysqli->query($queryFinal);
    if (!$result) {
        die("Error en la consulta: " . $mysqli->error);
    }

    // Inicia la tabla
    echo "<section class='content'>
    <div class='card-body'>
        <div class='table-responsive'>
            <table style='width:1300px;'>
                <thead>
                    <tr>
                        <th>CUENTA</th>
                        <th>DOCUMENTO</th>
                        <th>NOMBRE</th>
                        <th>PLAN</th>
                        <th>COBERTURA</th>
                        <th>CUOTA</th>
                        <th>BENEFICIARIOS</th>
                        <th>OBSERVACIONES </th>
                        <th>ESTADO </th>
                        <th>EDITAR</th>
                        <th>ELIMINAR</th>
                    </tr>
                </thead>
                <tbody>";

    $i = 1;
    while ($row = mysqli_fetch_array($result)) {
        if ($row['num_ofe_cta'] != 0) {
            echo '<tr>
            <td data-label="CUENTA">' . $row['num_ofe_cta'] . '</td>
            <td data-label="CEDULA">' . $row['num_doc_cta'] . '</td>
            <td style="text-transform:uppercase;" data-label="NOMBRE">' . $row['nom_cta'] . ' ' . $row['ape_cta'] . '</td>
            <td data-label="ESTRATO">' . $row['plan_cta'] . '</td>
            <td data-label="TELEFONO">' . strtolower($row['cob_cta']) . '</td>
            <td data-label="CUOTA">' . $row['vlr_cuo_cta'] . '</td>
            <td data-label="BENEFICIARIOS">' . $row['ctd_ben_cta'] . '</td>
            <td data-label="OBSERVACIONES">' . $row['obs_cta'] . '</td>
            <td data-label="ESTADO">' . getStatus($row['estado_cta']) . '</td>
            <td data-label="EDITAR">
                <a href="editClient.php?num_ofe_cta=' . $row['num_ofe_cta'] . '">
                    <img src="../img/editar.png" width=28 height=28>
                </a>
            </td>
            <td data-label="ELIMINAR">
                <a href="?delete=' . $row['num_ofe_cta'] . '" onclick="return confirm(\'¿Estás seguro de que deseas eliminar esta cuenta?\');">
                    <i class="fa-sharp-duotone fa-solid fa-trash" style="color:red; height:20px;"></i>
                </a>
            </td>   
        </tr>';
            $i++;
        }
    }

    // Cierra la tabla y muestra la paginación
    echo '</tbody></table></div>';

    // Mostrar la paginación después de la tabla
    $paginacion->render();
    echo '</section>';

    ?>

    <center>
        <br /><a href="../access.php"><img src='../img/atras.png' width="72" height="72" title="Regresar" /></a>
    </center>

    <script src="https://www.jose-aguilar.com/scripts/fontawesome/js/all.min.js" data-auto-replace-svg="nest"></script>

</body>

</html>