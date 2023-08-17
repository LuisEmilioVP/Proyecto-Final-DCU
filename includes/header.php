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
    <?php
      $isIndex = strpos($_SERVER['REQUEST_URI'], '/index') !== false;

      $Index = $isIndex ? './index' : '../../index.php';
      $Aulas = $isIndex ? './pages/aulas/aulas_profile.php' : '../aulas/aulas_profile.php';
      $Materias = $isIndex ? './pages/materias/materias_profile.php' : '../materias/materias_profile.php';
      $Admin = $isIndex ? './pages/admin/admin_profile.php' : '../admin/admin_profile.php';
      $Profesor = $isIndex ? './pages/profesores/profesores_profile.php' : '../profesores/profesores_profile.php';
      $Estudiante = $isIndex ? './pages/estudiantes/estudiantes_profile.php' : '../estudiantes/estudiantes_profile.php';
    ?>

    <a href="<?php echo $Index; ?>" class="logo">Admin <span>Panel</span></a>

    <nav class="navbar">
      <a href="<?php echo $Index; ?>">Inicio</a>
      <a href="<?php echo $Aulas; ?>">Aulas</a>
      <a href="<?php echo $Materias; ?>">Materias</a>
      <a href="<?php echo $Profesor; ?>">Profesores</a>
      <a href="<?php echo $Estudiante; ?>">Estudiantes</a>
      <a href="<?php echo $Admin; ?>">Administradores</a>
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
      <?php
        $Img = $isIndex ? './assets/images_cargadas/' : '../../assets/images_cargadas/';
      ?>
      <div class="flex-btn">
        <img src="<?= $Img . $fetch_profile['Foto']; ?>" alt="">
        <p><?= $fetch_profile['Nombre'];?></p>
        <a href="update_pass.php" class="btn">Actualizar Clave</a>
      </div>

      <div class="flex-btn">
        <?php
        $isAdmin= strpos($_SERVER['REQUEST_URI'], '/pages/admin/') !== false;

        $Login = $isIndex 
          ? ($isAdmin ? '': './pages/admin/admin_login.php') : ($isAdmin ? './admin_login.php': '../admin/admin_login.php');

        $Registro = $isIndex 
          ? ($isAdmin ? '': './pages/admin/registro_admin.php') : ($isAdmin ? './registro_admin.php': '../admin/registro_admin.php');
      ?>
        <a href="<?php echo $Login; ?>" class="option-btn">Iniciar sesión</a>
        <a href="<?php echo $Registro; ?>" class="option-btn">Registrarse</a>
      </div>
      <?php
        $Logout = $isIndex ? './includes/logout.php' : '../../includes/logout.php';
      ?>
      <a href="<?php echo $Logout; ?>" onclick="return confirm('¿Está seguro de cerrar sección en este sitio web?');"
        class="delete-btn">Cerrar sesión</a>
    </div>
  </section>
</header>