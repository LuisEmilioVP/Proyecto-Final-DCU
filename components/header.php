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
    <a href="home.php" class="logo">Admin <span>Panel</span></a>

    <nav class="navbar">
      <a href="home.php">Inicio</a>
      <a href="#">Aulas</a>
      <a href="#">Materias</a>
      <a href="#">Profesores</a>
      <a href="#">Estudiantes</a>
      <a href="admin_profile.php">Administradores</a>
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

      <div class="flex-btn">
        <img src="../images_cargadas/<?= $fetch_profile['Foto']; ?>" alt="">
        <p><?= $fetch_profile['Nombre'];?></p>
        <a href="update_pass.php" class="btn">Actualizar Clave</a>
      </div>

      <div class="flex-btn">
        <a href="admin_login.php" class="option-btn">Iniciar sesión</a>
        <a href="registro_admin.php" class="option-btn">Registrarse</a>
      </div>
      <a href="components/logout.php" onclick="return confirm('¿Está seguro de cerrar sección en este sitio web?');"
        class="delete-btn">Cerrar sesión</a>
    </div>
  </section>
</header>