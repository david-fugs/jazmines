<?php 
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
header("Content-Type: text/html;charset=utf-8");
date_default_timezone_set("America/Bogota");
include("conexion.php");

if(isset($_POST["importar"])){

    //--- LIBRERIA PHP EXCEL --- SECCION 1 ---
    require_once("Classes/PHPExcel/IOFactory.php");
    require_once("Classes/PHPExcel.php");
    
    //--- SECCION 2 --- 
    $archivo = $_FILES["archivo"]["name"];
    $archivo_ruta = $_FILES["archivo"]["tmp_name"];
    $archivo_guardado = "COPIA_".$archivo;

    if(copy($archivo_ruta, $archivo_guardado)){
        // echo "ARCHIVO COPIADO";
    }else{
        echo "NO COPIADO";
    }

    //--- SECCION 3 ---
    $objPHPExcel = PHPEXCEL_IOFactory::load($archivo_guardado);
        
    $objPHPExcel->setActiveSheetIndex(0); //Leer hoja numero 0
        
    $num_filas = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow(); // obtener fila de la hoja activa

    //echo "<center><table border=1><tr><th>FECHA REGISTRO</th><th>TIP. DOC.</th><th>No.</th><th>NOMBRES - APELLIDOS</th><th>DIRECCIÓN</th><th>CIUDAD</th><th>BARRIO</th><th>TELÉFONO</th><th>CELULAR</th><th>EPS</th><th>ARL</th><th>AFP</th><th>FACTOR RH</th><th>EMPRESA VINCULADO</th><th>PLACA</th><th>No. INTERNO</th><th>TIPO VINCULACIÓN</th> </tr>";
    for($i = 2; $i <= $num_filas; $i++){
           
        //--- NOMBRE 
        $fec_con = date('Y-m-d H:i:s');
        
        //--- IDENTIFICACION 
        $tip_doc_con = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
        
        //--- CUENTA  
        $num_doc_con = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();

        //--- TIPO 
        $nom_ape_con = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();

        //--- IDENTIFICACION 
        $dir_con = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
        
        //--- CUENTA  
        $ciu_con = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();

        //--- TIPO 
        $bar_con = $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();

        //--- NOMBRE 
        $tel1_con = $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
        
        //--- IDENTIFICACION 
        $tel2_con = $objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();
        
        //--- CUENTA  
        $eps_con = $objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue();

        //--- TIPO 
        $arl_con = $objPHPExcel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue();

        //--- NOMBRE 
        $afp_con = $objPHPExcel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue();
        
        //--- IDENTIFICACION 
        $tip_san_con = $objPHPExcel->getActiveSheet()->getCell('L'.$i)->getCalculatedValue();
        
        //--- CUENTA  
        $emp1_con = $objPHPExcel->getActiveSheet()->getCell('M'.$i)->getCalculatedValue();

        //--- TIPO 
        $pla1_con = $objPHPExcel->getActiveSheet()->getCell('N'.$i)->getCalculatedValue();

        $int1_con = $objPHPExcel->getActiveSheet()->getCell('O'.$i)->getCalculatedValue();
        
        //--- IDENTIFICACION 
        $tip_vin_con = $objPHPExcel->getActiveSheet()->getCell('P'.$i)->getCalculatedValue();

        $estado_con = $objPHPExcel->getActiveSheet()->getCell('Q'.$i)->getCalculatedValue();
        
        //$fec_con=(date_default_timezone_set("America/Bogota" date('Y-m-d')));
        //--- IMPRIMIR EN HTML 
       /*echo "<tr>";
        echo "<td>".$fec_con."</td>";
        echo "<td>".$tip_doc_con."</td>";
        echo "<td>".$num_doc_con."</td>";
        echo "<td>".$nom_ape_con."</td>";
        echo "<td>".$dir_con."</td>";
        echo "<td>".$ciu_con."</td>";
        echo "<td>".$bar_con."</td>";
        echo "<td>".$tel1_con."</td>";
        echo "<td>".$tel2_con."</td>";
        echo "<td>".$eps_con."</td>";
        echo "<td>".$arl_con."</td>";
        echo "<td>".$afp_con."</td>";
        echo "<td>".$tip_san_con."</td>";
        echo "<td>".$emp1_con."</td>";
        echo "<td>".$pla1_con."</td>";
        echo "<td>".$int1_con."</td>";
        echo "<td>".$tip_vin_con."</td>";
        echo "<td>".$estado_con."</td>";
        echo "</tr>";*/
       

        // --- SECCION 4 ---
        
        $sql = "REPLACE INTO conductores_consota (fec_con, tip_doc_con, num_doc_con, nom_ape_con, dir_con, ciu_con, bar_con, tel1_con, tel2_con, eps_con, arl_con, afp_con, tip_san_con, emp1_con, pla1_con, int1_con, tip_vin_con, estado_con) values ('$fec_con', '$tip_doc_con', '$num_doc_con', '$nom_ape_con', '$dir_con', '$ciu_con','$bar_con','$tel1_con','$tel2_con','$eps_con','$arl_con','$afp_con','$tip_san_con','$emp1_con','$pla1_con','$int1_con','$tip_vin_con','$estado_con')";
         //echo $sql;
        $resultado = mysqli_query($conexion, $sql);
    }
    echo "</table></center>";

    if($resultado){
        echo "<B><H1>EL PROCESO DE IMPORTAR DATOS SE HA REALIZADO DE FORMA CORRECTA</B></H1>";
    }else{
        echo "Error no insertado";
    }
}

if(isset($_POST["exportar"])){
        
    $fila = 2;
        
    require_once 'Classes/PHPExcel.php';
        
    // Crea un nuevo objeto PHPExcel
    $objPHPExcel = new PHPExcel();
        
    // Establecer propiedades
    $objPHPExcel->getProperties()
    ->setCreator("AMCO")
    ->setLastModifiedBy("AMCO")
    ->setTitle("Documento Excel")
    ->setSubject("Documento Excel")
    ->setDescription("CONDUCTORES")
    ->setKeywords("Excel Office 2007 openxml php")
    ->setCategory("EXPORT EXCEL");
        
    // Agregar Informacion
    $objPHPExcel->setActiveSheetIndex(0)
    //->setCellValue('A1','FECHA_REGISTRO')
    ->setCellValue('A1','TIP_DOC')
    ->setCellValue('B1','No')
    ->setCellValue('C1','NOMBRES_APELLIDOS')
    ->setCellValue('D1','DIRECCION')
    ->setCellValue('E1','CIUDAD')
    ->setCellValue('F1','BARRIO')
    ->setCellValue('G1','TELEFONO_PRINCIPAL')
    ->setCellValue('H1','TELEFONO_ALTERNO')
    ->setCellValue('I1','EPS')
    ->setCellValue('J1','ARL')
    ->setCellValue('K1','AFP')
    ->setCellValue('L1','FACTOR_RH')
    ->setCellValue('M1','EMPRESA_VINCULADO')
    ->setCellValue('N1','PLACA')
    ->setCellValue('O1','No_INTERNO')
    ->setCellValue('P1','TIPO_VINCULACION')
    ->setCellValue('Q1','ESTADO_CONDUCTOR');
		
    $sql = "SELECT * FROM  conductores_consota WHERE emp1_con='consota'";
    $consulta = mysqli_query($conexion, $sql);
    
    while($row = mysqli_fetch_array($consulta)){
        //$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $row['fec_con']);
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $row['tip_doc_con']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $row['num_doc_con']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $row['nom_ape_con']);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $row['dir_con']);
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, $row['ciu_con']);
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, $row['bar_con']);
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, $row['tel1_con']);
        $objPHPExcel->getActiveSheet()->setCellValue('H'.$fila, $row['tel2_con']);
        $objPHPExcel->getActiveSheet()->setCellValue('I'.$fila, $row['eps_con']);
        $objPHPExcel->getActiveSheet()->setCellValue('J'.$fila, $row['arl_con']);
        $objPHPExcel->getActiveSheet()->setCellValue('K'.$fila, $row['afp_con']);
        $objPHPExcel->getActiveSheet()->setCellValue('L'.$fila, $row['tip_san_con']);
        $objPHPExcel->getActiveSheet()->setCellValue('M'.$fila, $row['emp1_con']);
        $objPHPExcel->getActiveSheet()->setCellValue('N'.$fila, $row['pla1_con']);
        $objPHPExcel->getActiveSheet()->setCellValue('O'.$fila, $row['int1_con']);
        $objPHPExcel->getActiveSheet()->setCellValue('P'.$fila, $row['tip_vin_con']);
        $objPHPExcel->getActiveSheet()->setCellValue('Q'.$fila, $row['estado_con']);
        $fila++;
	}
        
    // Renombrar Hoja
    $objPHPExcel->getActiveSheet()->setTitle('BD');
        
    // Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
    $objPHPExcel->setActiveSheetIndex(0);
		
    // Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="CONSOTA.xlsx"');
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
        <title>SOFT | AMCO</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="html_t1_editable.css" rel="stylesheet">
        <link href="index.css" rel="stylesheet">
        <script src="jquery-1.12.4.min.js"></script>
        <script>
            $(document).ready(function () {
                $("#file_archivo :file").on('change', function () {
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
                            <center><p style="border-radius: 20px;box-shadow: 10px 10px 5px #04B404; font-size: 23px; font-weight: bold;" ><img src='../images/amco2020.png' width=500 heigth=131 style="display: inline-block;"><BR/>IMPORTAR Y EXPORTAR DATOS CONDUCTORES<br><br></p></center>
                        </div>
                        
                        <span style="color:#04B404;font-family:'Source Sans Pro';font-size:20px;"><B>NOTA: </B>Si desea subir información a través del archivo de Excel, debe cumplir con las características solicitadas. <b><i><A href='formato_V6.xlsx'>Descargue desde aquí el formato...</i></b></A>
                                <br><br>
                            </span>
                            <span style="color:#4F4F4F;font-family:'Source Sans Pro';font-size:20px;">Puede descargar el <b><i><A href='manual_V6.pdf'>manual</a> que indica el proceso y manejo de la información en el formato, <U><B>SE RECOMIENDA LEER PRIMERO ESTE MANUAL ANTES DE REALIZAR EL PROCESO DE CARGUE DE LA INFORMACIÓN.</B></U></span>
                            <span style="color:#000000;font-family:'Source Sans Pro';font-size:27px;">
                                <br>
                            </span>
                
               
                    </div>
                </div>
            </div>
        </div>

        <div id="wb_LayoutGrid1">
            <form name="frm" method="post" action="" enctype="multipart/form-data" accept-charset="UTF-8" id="LayoutGrid1">
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
                                    <div class="col-1">
                                        <input type="submit" id="btn_exportar" name="exportar" value="Exportar" style="display:inline-block;width:96px;height:25px;z-index:1;">
                                    </div>
                                </div>
                                <center>

        
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        
        </div>
        <p><a href='../logueo/consota.php'><img src='../images/regresar.jpg' title="Regresar"></a></p>
        

        
        <div id="wb_footer">
            <div id="footer">
                <div class="row">
                    <div class="col-1">
                        <!--<div id="wb_text_footer">
                            <span style="color:#000000;font-family:'Source Sans Pro';font-size:27px;">
                                <br>
                            </span>
                            <span style="color:#4F4F4F;font-family:'Source Sans Pro';font-size:21px;">DEPARTAMENTO DE SISTEMAS - AMCO
                                <br>
                            </span>
                            <span style="color:#4F4F4F;font-family:'Source Sans Pro';font-size:16px;"></span>
                            <span style="color:#000000;font-family:'Source Sans Pro';font-size:27px;">
                                <br>
                            </span>
                        </div>-->
                    </div>
                </div>
            </div>
        </div>
    </body>

    </html>