<?php
include './components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
  header('location:./admin_login.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<?php
  include './components/header.php';
?>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel Administrativo</title>
  <!-- Favicon -->
  <link rel="shortcut icon" href="" type="image/x-icon">
  <!-- Font awesome cdn link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <!-- Custom css file link  -->
  <link rel="stylesheet" href="./css/main.css">
</head>

<body>
  <!-- Admin dashboard section starts -->
  <section class="dashboard">
    <h1 class="heading">Panel de Administración</h1>
    <div class="box-container">
      <div class="box">
        <h3>Bienvenido</h3>
        <img src="../images_cargadas/<?= $fetch_profile['Foto']; ?>" alt="" height="100">
        <p><?= $fetch_profile['Nombre'];?></p>
        <a href="update_pass.php" class="btn">Actualizar Clave</a>
      </div>

      <div class="box">
        <?php 
          $select_admins = $connect->prepare("SELECT * FROM `aula`");
          $select_admins->execute();
          $number_of_admins = $select_admins->rowCount();
        ?>
        <h3><?= $number_of_admins; ?></h3>
        <p>Aulas Agregados</p>
        <a href="aulas_profile.php" class="btn">Ver Aulas</a>
      </div>

      <div class="box">
        <?php 
          $select_admins = $connect->prepare("SELECT * FROM `administrativo`");
          $select_admins->execute();
          $number_of_admins = $select_admins->rowCount();
        ?>
        <h3><?= $number_of_admins; ?></h3>
        <p>Administradores Agregados</p>
        <a href="admin_profile.php" class="btn">Ver Administradores</a>
      </div>
    </div>
  </section>

  <?php
  include './components/footer.php';
  ?>
  <!-- Admin dashboard section end -->
  <!-- Custom js file link -->
  <script src="./js/main.js"></script>
</body>

</html>