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
        echo "Las siguientes cuentas ya existen en la base de datos:";
        echo "<ul>";
        foreach ($cuentasDuplicadas as $cuenta) {
            echo "<li>La cuenta <b> $cuenta</b> ya se encuentra registrada.</li>";
        }
        echo "</ul>";
    } else {
        echo "<h3>Todos los registros fueron insertados correctamente.</h3>";
    }
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
    <div id="container">
    </div>
    <div id="wb_header">
        <div id="header">
            <div class="row">
                <div class="col-1">
                    <div id="wb_Text1">
                        <center>
                            <p style="border-radius: 20px;box-shadow: 10px 10px 5px #b1940b; font-size: 23px; font-weight: bold;"><img src='../img/logo.png' width="400" height="205" style="display: inline-block;"><BR />IMPORTAR Y EXPORTAR DATOS INFORMACION CLIENTES<br><br></p>
                        </center>
                    </div>
                    <span style="color:#80938f;font-family:'Source Sans Pro';font-size:20px;"><B>NOTA: </B>Si desea subir información a través del archivo de Excel, debe cumplir con las características solicitadas. <b><i><A href='formato_V1.xlsx'>Descargue desde aquí el formato...</i></b></A>
                        <br><br>
                    </span>
                    <span style="color:#000000;font-family:'Source Sans Pro';font-size:27px;">
                        <br>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div id="wb_LayoutGrid1">
        <form name="frm" method="POST" action="" enctype="multipart/form-data" accept-charset="UTF-8" id="LayoutGrid1">
            <div class="row">
                <div class="col-1">
                    <div id="file_archivo" class="input-group" style="display:table;width:100%;height:16px;z-index:2;">
                        <input class="form-control" type="text" readonly="">
                        <label class="input-group-btn">
                            <input type="file" name="archivo" style="display:none;">
                            <span class="btn">Seleccionar archivo...</span>
                        </label>
                    </div>
                    <input type="submit" id="btn_cargar" name="importar" value="Cargar" style="display:inline-block;width:96px;height:25px;z-index:3;">
                    <div id="wb_LayoutGrid2">
                        <div id="LayoutGrid2">
                            <div class="row">
                            <center>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <p><a href='../conex/access.php'><img src='../img/atras.png' width="80" height="80" title="Regresar"></a></p>

</body>

</html>