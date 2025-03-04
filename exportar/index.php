<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

header("Content-Type: text/html;charset=utf-8");
date_default_timezone_set("America/Bogota");
include("conexion.php");

if (isset($_POST["importar"])) {
    require_once("Classes/PHPExcel/IOFactory.php");
    require_once("Classes/PHPExcel.php");
    require_once("conexion.php"); // Asegúrate de incluir la conexión a la base de datos

    mysqli_report(MYSQLI_REPORT_OFF); // Desactivar reporte de errores de MySQLi

    $archivo = $_FILES["archivo"]["name"];
    $archivo_ruta = $_FILES["archivo"]["tmp_name"];
    $archivo_guardado = "COPIA_" . $archivo;

    if (!copy($archivo_ruta, $archivo_guardado)) {
        echo "Error al copiar el archivo.";
        exit;
    }

    $objPHPExcel = PHPExcel_IOFactory::load($archivo_guardado);
    $objPHPExcel->setActiveSheetIndex(0);
    $num_filas = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

    date_default_timezone_set("America/Bogota");

    $cuentasDuplicadas = []; // Mover la variable fuera del for
    for ($i = 2; $i <= $num_filas; $i++) {
        $num_ofe_cta = $objPHPExcel->getActiveSheet()->getCell('A' . $i)->getCalculatedValue();
        $num_doc_cta = $objPHPExcel->getActiveSheet()->getCell('B' . $i)->getCalculatedValue();
        $nom_cta = $objPHPExcel->getActiveSheet()->getCell('C' . $i)->getCalculatedValue();
        $ape_cta = $objPHPExcel->getActiveSheet()->getCell('D' . $i)->getCalculatedValue();
        $plan_cta = $objPHPExcel->getActiveSheet()->getCell('E' . $i)->getCalculatedValue();
        $cob_cta = $objPHPExcel->getActiveSheet()->getCell('F' . $i)->getCalculatedValue();
        $vlr_cuo_cta = $objPHPExcel->getActiveSheet()->getCell('G' . $i)->getCalculatedValue();
        $ctd_ben_cta = $objPHPExcel->getActiveSheet()->getCell('H' . $i)->getCalculatedValue();
        $obs_cta = $objPHPExcel->getActiveSheet()->getCell('I' . $i)->getCalculatedValue();
        $estado_cta = $objPHPExcel->getActiveSheet()->getCell('J' . $i)->getCalculatedValue();
        $sql_check = "SELECT num_ofe_cta FROM cuenta WHERE num_ofe_cta = '$num_ofe_cta'";
        $result_check = mysqli_query($conexion, $sql_check);

        if (mysqli_num_rows($result_check) > 0) {
            $cuentasDuplicadas[] = $num_ofe_cta; // Guardar cuenta duplicada
        } else {
            $sql = "INSERT INTO cuenta (num_ofe_cta, num_doc_cta, nom_cta, ape_cta, plan_cta, cob_cta, vlr_cuo_cta, ctd_ben_cta, obs_cta, estado_cta) 
                    VALUES ('$num_ofe_cta', '$num_doc_cta', '$nom_cta', '$ape_cta', '$plan_cta', '$cob_cta', '$vlr_cuo_cta', '$ctd_ben_cta', '$obs_cta', '$estado_cta')";

            $resultado = mysqli_query($conexion, $sql);
            if (!$resultado) {
                echo "<p>Error en la fila $i: " . mysqli_error($conexion) . "</p>";
            }
        }
    }

    $cuentasDuplicadas = array_filter($cuentasDuplicadas, function ($cuenta) {
        return !is_null($cuenta) && $cuenta !== '';
    });
    // Mostrar todas las cuentas duplicadas al final
    if (!empty($cuentasDuplicadas)) {
        $mensaje = "Las siguientes cuentas ya existen en la base de datos:\n";
        foreach ($cuentasDuplicadas as $cuenta) {
            $mensaje .= "- La cuenta $cuenta ya se encuentra registrada.\n";
        }
    } else {
        $mensaje = "Todos los registros fueron insertados correctamente.";
    }

    echo "<script>
        alert(`$mensaje`);
        window.location.href = '../conex/client/showClients.php';
    </script>";
}
if (isset($_POST["exportar"])) {
    $fila = 2;
    require_once 'Classes/PHPExcel.php';

    // Crea un nuevo objeto PHPExcel
    $objPHPExcel = new PHPExcel();

    // Establecer propiedades
    $objPHPExcel->getProperties()
        ->setCreator("EUMIR PULIDO DE LA PAVA")
        ->setLastModifiedBy("EUMIR PULIDO DE LA PAVA")
        ->setTitle("Documento Excel")
        ->setSubject("Documento Excel")
        ->setDescription("SOFTWARE")
        ->setKeywords("Excel Office 2007 openxml php")
        ->setCategory("EXPORT EXCEL");

    // Agregar Informacion
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1', 'CUENTA')
        ->setCellValue('B1', 'DOCUMENTO')
        ->setCellValue('C1', 'NOMBRES')
        ->setCellValue('D1', 'APELLIDOS')
        ->setCellValue('E1', 'PLAN')
        ->setCellValue('F1', 'COBERTURA')
        ->setCellValue('G1', 'CUOTA')
        ->setCellValue('H1', 'BENEFICIARIOS')
        ->setCellValue('I1', 'OBSERVACIONES')
        ->setCellValue('J1', 'ESTADO');

    while ($row = mysqli_fetch_array($consulta)) {
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $fila, $row['num_ofe_cta']);
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $fila, $row['num_doc_cta']);
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $fila, $row['nom_cta']);
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $fila, $row['ape_cta']);
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $fila, $row['plan_cta']);
        $objPHPExcel->getActiveSheet()->setCellValue('F' . $fila, $row['cob_cta']);
        $objPHPExcel->getActiveSheet()->setCellValue('G' . $fila, $row['vlr_cuo_cta']);
        $objPHPExcel->getActiveSheet()->setCellValue('H' . $fila, $row['ctd_ben_cta']);
        $objPHPExcel->getActiveSheet()->setCellValue('I' . $fila, $row['obs_cta']);
        $objPHPExcel->getActiveSheet()->setCellValue('J' . $fila, $row['estado_cta']);
        $fila++;
    }

    // Renombrar Hoja
    $objPHPExcel->getActiveSheet()->setTitle('BD');

    // Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
    $objPHPExcel->setActiveSheetIndex(0);

    // Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Nueva_data_clientes.xlsx"');
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    exit;
}


?>
<!doctype html>
<html>

<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta charset="utf-8">
    <title>SOFT</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="html_t1_editable.css" rel="stylesheet">
    <link href="index.css" rel="stylesheet">
    <script src="jquery-1.12.4.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#file_archivo :file").on('change', function() {
                var input = $(this).parents('.input-group').find(':text');
                input.val($(this).val());
            });
        });
    </script>
</head>

<body>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Importar y Exportar Datos</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body {
                background-color: #f8f9fa;
            }

            .header-container {
                text-align: center;
                padding: 20px;
                background: #fff;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                border-radius: 10px;
                margin-bottom: 20px;
            }

            .note {
                font-size: 18px;
                color: #555;
            }

            .custom-file-label::after {
                content: "Seleccionar";
            }
        </style>
    </head>

    <body>
        <div class="container mt-5">
            <div class="header-container">
                <img src="../img/logo.png" width="400" height="205" alt="Logo">
                <h2 class="mt-3">IMPORTAR Y EXPORTAR DATOS INFORMACIÓN CLIENTES</h2>
                <p class="note"><strong>NOTA:</strong> Si desea subir información a través del archivo de Excel, debe cumplir con las características solicitadas.
                    <a href='formato_V1.xlsx' class="text-primary fw-bold">Descargue desde aquí el formato...</a>
                </p>
            </div>

            <div class="card p-4">
                <form name="frm" method="POST" action="" enctype="multipart/form-data" accept-charset="UTF-8">
                    <div class="mb-3">
                        <label for="archivo" class="form-label">Seleccionar archivo</label>
                        <input class="form-control" type="file" name="archivo" id="archivo">
                    </div>
                    <button type="submit" id="btn_cargar" name="importar" class="btn btn-primary">Cargar</button>
                </form>
            </div>

            <div class="text-center mt-4">
                <a href='../conex/access.php'>
                    <img src='../img/atras.png' width="80" height="80" title="Regresar">
                </a>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>