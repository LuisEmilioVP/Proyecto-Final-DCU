<?php
include '../../includes/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
  header('location:admin_login.php');
};

if(isset($_GET['delete'])){
  $delete_id = $_GET['delete'];

  $delete_admins = $connect->prepare("DELETE FROM `administrativo` WHERE IdAmin = ?");
  $delete_admins->execute([$delete_id]);

  header('location:admin_profile.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<?php
  include '../../includes/header.php';
?>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel / Administradores</title>
  <!-- Favicon -->
  <link rel="shortcut icon" href="" type="image/x-icon">
  <!-- Font awesome cdn link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <!-- Custom css file link  -->
  <link rel="stylesheet" href="../../assets/css/main.css">
</head>

<body>
  <!-- Admin accounts section starts -->
  <section class="accounts">
    <h1 class="heading">Cuentas de administrador</h1>
    <div class="box-container">
      <div class="box">
        <?php 
          $select_admins = $connect->prepare("SELECT * FROM `administrativo`");
          $select_admins->execute();
          $number_of_admins = $select_admins->rowCount();
        ?>
        <p>Administradores agregadas</p>
        <p><?= $number_of_admins; ?></p>
        <a href="registro_admin.php" class="option-btn">registrar administrador</a>
      </div>
    </div>
    <br>
    <br>
    <div class="box-container">
      <?php
      $select_accounts = $connect->prepare("SELECT * FROM `administrativo`");
      $select_accounts->execute();
      if($select_accounts->rowCount() > 0){
        while($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)){   
      ?>
      <div class="box">
        <img src="../../assets/images_cargadas/<?= $fetch_accounts['Foto']; ?>" alt="" width="100">
        <p>Administrador: <span><?= $fetch_accounts['Nombre'], ' ', $fetch_accounts['Apellido']; ?></span> </p>
        <div class="details"><span><?= $fetch_accounts['Genero']; ?></span></div>
        <div class="details"><span><?= $fetch_accounts['Correo']; ?></span></div>
        <div class="details"><span><?= $fetch_accounts['Telefono']; ?></span></div>
        <div class="details"><span><?= $fetch_accounts['Cargo']; ?></span></div>
        <div class="flex-btn">

          <a href="update_profile.php?update=<?= $fetch_accounts['IdAmin']; ?>" class="option-btn">Actualizar</a>

          <a href="admin_profile.php?delete=<?= $fetch_accounts['IdAmin']; ?>"
            onclick="return confirm('¿Quieres eliminar esta cuenta?')" class="delete-btn">Eliminar</a>
        </div>
      </div>
      <?php
        }
      }else{
        echo '<p class="empty">¡No hay cuentas disponibles!</p>';
      }
      ?>
    </div>
  </section>
  <!-- Admin accounts section ends -->

  <?php
    include '../../includes/footer.php';
  ?>
  <!-- Custom js file link -->
  <script src="../../assets/js//main.js"></script>
</body>

</html>