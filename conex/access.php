<?php
    session_start();
    
    if(!isset($_SESSION['id'])){
        header("Location: index.php");
    }
    
    $usuario = $_SESSION['usuario'];
    $nombre = $_SESSION['nombre'];
    $tipo_usuario = $_SESSION['tipo_usuario'];
?>

<!DOCTYPE html>
<!-- Coding by CodingNepal || www.codingnepalweb.com -->
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- Boxicons CSS -->
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/fed2435e21.js" crossorigin="anonymous"></script>
  <title>JAZMINES | SOFT</title>
  <link href="fontawesome/css/all.css" rel="stylesheet">
  <link rel="stylesheet" href="css/styleAccess.css" />
</head>

<body>
  <!-- navbar -->
  <nav class="navbar">
    <div class="logo_item">
      <i class="bx bx-menu" id="sidebarOpen"></i>
      <img src="../img/logo.png" alt=""></i>JAZMINES | SOFT
    </div>

    <!--<div class="search_bar">
        <input type="text" placeholder="Buscar..." />
      </div>-->

    <div class="navbar_content">
      <i class="bi bi-grid"></i>
      <i class="fa-solid fa-sun" id="darkLight"></i><!--<i class='bx bx-sun' id="darkLight"></i>-->
      <a href="logout.php"> <i class="fa-solid fa-door-open"></i></a>
      <img src="../img/logo.png" alt="" class="profile" />
    </div>
  </nav>

  <!--************************INICIA MENÚ ADMINISTRADOR************************-->

  <?php if ($tipo_usuario == 1) { ?>
    <!-- sidebar -->
    <nav class="sidebar">
      <div class="menu_content">
        <ul class="menu_items">
          <div class="menu_title menu_dahsboard"></div>
          <li class="item">
            <div href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
                <i class="fa-solid fa-people-group"></i>
              </span>
              <span class="navlink">CLIENTES</span>
              <i class="bx bx-chevron-right arrow-left"></i>
            </div>

            <ul class="menu_items submenu">
              <a href="../exportar/index.php" class="nav_link sublink">Importar datos clientes</a>
              <a href="code/mie/showMembers.php" class="nav_link sublink">Consultar Clientes</a>
            </ul>
          </li>
          <li class="item">
            <div href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
                <i class="fa-solid fa-person"></i>
              </span>
              <span class="navlink">Lideres</span>
              <i class="bx bx-chevron-right arrow-left"></i>
            </div>
            <ul class="menu_items submenu">
              <a href="code/leaders/createLeaders.php" class="nav_link sublink">Crear Lider</a>
              <a href="code/leaders/showLeaders.php" class="nav_link sublink">Consultar lideres</a>
            </ul>
          </li>
          <li class="item">
            <div href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
                <i class="fa-sharp fa-solid fa-cake-candles"></i> </span>
              <span class="navlink">Cumpleaños</span>
              <i class="bx bx-chevron-right arrow-left"></i>
            </div>
            <ul class="menu_items submenu">
              <a href="code/birthday/showBirthday.php" class="nav_link sublink">Ver Cumpleaños</a>
            </ul>
          </li>

          <hr style="border: 1px solid #F3840D; border-radius: 5px;">
          <li class="item">
            <div href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
                <i class="fa-solid fa-screwdriver-wrench"></i>
              </span>
              <span class="navlink">Mi Cuenta</span>
              <i class="bx bx-chevron-right arrow-left"></i>
            </div>

            <ul class="menu_items submenu">
              <a href="reset-password.php" class="nav_link sublink">Cambiar Contraseña</a>
            </ul>
          </li>

          <!-- Sidebar Open / Close -->
          <div class="bottom_content">
            <div class="bottom expand_sidebar">
              <span> Expand</span>
              <i class='bx bx-log-in'></i>
            </div>
            <div class="bottom collapse_sidebar">
              <span> Collapse</span>
              <i class='bx bx-log-out'></i>
            </div>
          </div>
      </div>
    </nav>
  <?php } ?>


  <!--************************MENÚ ENCUESTAS DE CAMPO************************-->
  <?php if ($tipo_usuario == 2) { ?>
    <!-- sidebar -->
    <nav class="sidebar">
      <div class="menu_content">
        <ul class="menu_items">
          <div class="menu_title menu_dahsboard"></div>
          <li class="item">
            <div href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
                <i class="fa-solid fa-people-group"></i>
              </span>
              <span class="navlink">CLIENTES</span>
              <i class="bx bx-chevron-right arrow-left"></i>
            </div>

            <ul class="menu_items submenu">
              <a href="../exportar/index.php" class="nav_link sublink">Importar datos clientes</a>
              <a href="code/mie/showMembers.php" class="nav_link sublink">Ver Clientes</a>
            </ul>
          </li>
          <li class="item">
            <div href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
              <i class="fa-solid fa-magnifying-glass"></i> </span>
              <span class="navlink">CONSULTAR CLIENTE</span>
              <i class="bx bx-chevron-right arrow-left"></i>
            </div>
            <ul class="menu_items submenu">
              <a href="code/birthday/showBirthday.php" class="nav_link sublink">Consultar clientes</a>
            </ul>
          </li>
          <hr style="border: 1px solid #F3840D; border-radius: 5px;">
          <li class="item">
            <div href="#" class="nav_link submenu_item">
              <span class="navlink_icon">
                <i class="fa-solid fa-screwdriver-wrench"></i>
              </span>
              <span class="navlink">Mi Cuenta</span>
              <i class="bx bx-chevron-right arrow-left"></i>
            </div>

            <ul class="menu_items submenu">
              <a href="reset-password.php" class="nav_link sublink">Cambiar Contraseña</a>
            </ul>
          </li>

          <!-- Sidebar Open / Close -->
          <div class="bottom_content">
            <div class="bottom expand_sidebar">
              <span> Expand</span>
              <i class='bx bx-log-in'></i>
            </div>
            <div class="bottom collapse_sidebar">
              <span> Collapse</span>
              <i class='bx bx-log-out'></i>
            </div>
          </div>
      </div>
    </nav>
  <?php } ?>

  <!-- JavaScript -->
  <script src="js/script.js"></script>
</body>

</html>