<?php 
    include("../../conexion.php");
    session_start();
    
    if (!isset($_SESSION['id'])) {
        header("Location: ../../index.php");
        exit();
    }
    $num_ofe_cta = $_POST['num_ofe_cta'];
    $num_doc_cta = $_POST['num_doc_cta'];
    $nom_cta = $_POST['nom_cta'];
    $ape_cta = $_POST['ape_cta'];
    $plan_cta = $_POST['plan_cta'];
    $cob_cta = $_POST['cob_cta'];
    $vlr_cuo_cta = $_POST['vlr_cuo_cta'];
    $ctd_ben_cta = $_POST['ctd_ben_cta'];
    $obs_cta = $_POST['obs_cta'];
    $estado_cta = $_POST['estado_cta'];
    $sql = "INSERT INTO cuenta (num_ofe_cta, num_doc_cta, nom_cta, ape_cta, plan_cta, cob_cta, vlr_cuo_cta, ctd_ben_cta, obs_cta, estado_cta) 
            VALUES ('$num_ofe_cta', '$num_doc_cta', '$nom_cta', '$ape_cta', '$plan_cta', '$cob_cta', '$vlr_cuo_cta', '$ctd_ben_cta', '$obs_cta', '$estado_cta')";
    $resultado = $mysqli->query($sql);
    if ($resultado) {
        echo "<script>alert('Cuenta actualizada correctamente');
        window.location = 'showClients.php';</script>";
    } else {
        echo "<script>alert('Error al actualizar la cuenta');
        window.location = 'showClients.php';</script>";
    }
?>


    