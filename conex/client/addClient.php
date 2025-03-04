<?php

session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../../index.php");
    exit();
}

include("../../conexion.php");

header("Content-Type: text/html;charset=utf-8");
date_default_timezone_set("America/Bogota");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CT | SOFT</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <script type="text/javascript" src="../../js/jquery.min.js"></script>
    <script type="text/javascript" src="../../js/popper.min.js"></script>
    <script type="text/javascript" src="../../js/bootstrap.min.js"></script>
    <link href="../../fontawesome/css/all.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/fed2435e21.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <style>
        .responsive {
            max-width: 100%;
            height: auto;
        }

        .form-container {
            border: 1px solid #ccc;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            background-color: #f9f9f9;
        }

        fieldset {
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        legend {
            font-weight: bold;
            font-size: 0.9em;
            color: #4a4a4a;
            padding: 0 10px;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        /* Efecto de enfoque para el fieldset */
        fieldset:focus-within {
            background-color: #e6f7ff;
            /* Azul muy claro */
            box-shadow: 0 0 10px rgba(0, 123, 255, 0.3);
            /* Sombreado azul claro */
        }
    </style>

</head>

<body>

    <div class="container" style="margin-top: 29px;">
        <h1><img src='../../img/logo.png' width="171" height="85" class="responsive"><b>CREAR CUENTA</b></h1>
        <p><i><b>

        </p>
        <form id="registroForm" action='processClient.php' enctype="multipart/form-data" method="POST">
            <div class="row">
            </div>
            <div class="form-group">
                <fieldset>
                    <legend>DATOS CUENTA</legend>
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <label for="num_ofe_cta">* CUENTA:</label>
                            <input type='text' name='num_ofe_cta' class='form-control' id="num_ofe_cta" />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="num_doc_cta">* CEDULA:</label>
                            <input type='number' name='num_doc_cta' id="num_doc_cta" class='form-control' style="text-transform:uppercase;" />
                        </div>
                        <div class="col-12 col-sm-5">
                            <label for="nom_cta">* NOMBRES :</label>
                            <input type='text' name='nom_cta' id="nom_cta" class='form-control' style="text-transform:uppercase;" />
                        </div>
                    </div>
                    <div class="row  mt-3">
                        <div class="col-12 col-sm-4">
                            <label for="ape_cta">* APELIIDOS:</label>
                            <input type='text' name='ape_cta' id="ape_cta" class='form-control' style="text-transform:uppercase;" />
                        </div>
                        <div class="col-12 col-sm-3 ">
                            <label for="plan_cta">* PLAN:</label>
                            <input type='text' name='plan_cta' class='form-control' style="text-transform:uppercase;" />
                        </div>
                        <div class="col-12 col-sm-5">
                            <label for="cob_cta">* COBERTURA:</label>
                            <input type='text' name='cob_cta' class='form-control' style="text-transform:uppercase;" />
                        </div>
                        <div class="col-12 col-sm-4 mt-3">
                            <label for="vlr_cuo_cta">CUOTA:</label>
                            <input type='number' name='vlr_cuo_cta' class='form-control' style="text-transform:lowercase;" />
                        </div>
                        <div class="col-12 col-sm-3  mt-3">
                            <label for="ctd_ben_cta">BENEFICIARIOS:</label>
                            <input type='number' name='ctd_ben_cta' class='form-control' style="text-transform:lowercase;" />
                        </div>
                        <div class="col-12 col-sm-5  mt-3">
                            <label for="obs_cta">OBSERVACION:</label>
                            <input type='text' name='obs_cta' class='form-control' style="text-transform:lowercase;" />
                        </div>
                        <div class="col-12 col-sm-3  mt-3">
                            <label for="obs_cta">ESTADO:</label>
                            <select name="estado_cta" class="form-control">
                                <option value="1">ACTIVO</option>
                                <option value="0">INACTIVO</option>
                            </select>
                        </div>

                    </div>
                </fieldset>
            </div>
            <!-- Botones para enviar o resetear -->
            <button type="submit" id="submit-btn" class="btn btn-outline-warning  mt-3">
                <span class="spinner-border spinner-border-sm"></span>
                ACTUALIZAR CUENTA
            </button>
            <button type="reset" class="btn btn-outline-dark  mt-3" role='link' onclick="history.back();" type='reset'>
                <img src='../img/atras.png' width=27 height=27> REGRESAR
            </button>
        </form>
    </div>
</body>
<script src="../../js/jquery-3.1.1.js"></script>
<script type="text/javascript">
</script>

</html>