<?php 
    if (isset($message)) {
      foreach($message as $message){
        echo ' 
        <div class="message">
          <span>'.$message.'</span>
          <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>
        ';
      }
    };
?>

<header class="header">
  <section class="flex">
    <a href="../home.php" class="logo">Admin <span>Panel</span></a>

    <nav class="navbar">
      <a href="dashboard.php">Inicio</a>
      <a href="productos.php">Aulas</a>
      <a href="pedidos_puestos.php">Materias</a>
      <a href="admin_cuentas.php">Profesores</a>
      <a href="cuentas_usuarios.php">Estudiantes</a>
      <a href="mensajes.php">Administradores</a>
    </nav>

    <div class="icons">
      <div id="menu-btn" class="fas fa-bars"></div>
      <div id="user-btn" class="fas fa-user"></div>
    </div>

    <div class="profile">
      <?php 
        $select_profile = $connect->prepare("SELECT * FROM `administrativo` WHERE IdAmin = ?");
        $select_profile->execute([$admin_id]);
        $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
      ?>
      <p><?= $fetch_profile['Nombre'];?></p>
      <a href="actualizar_perfil.php" class="btn">Actualizar Perfil</a>

      <div class="flex-btn">
        <a href="admin_login.php" class="option-btn">Iniciar sesión</a>
        <a href="registro_admin.php" class="option-btn">Registrarse</a>
      </div>
      <a href="../components/admin_logout.php" onclick="return confirm('¿Cerrar sesión en este sitio web?');"
        class="delete-btn">Cerrar sesión</a>
    </div>
  </section>
</header>