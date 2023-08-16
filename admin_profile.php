<?php
include './components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
  header('location:admin_login.php');
};

if(isset($_GET['delete'])){
  $delete_id = $_GET['delete'];
  $delete_admins = $connect->prepare("DELETE FROM `administrativo` WHERE IdAmin = ?");
  $delete_admins->execute([$delete_id]);
  header('location:admin_login.php');
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
  <title>Admin Panel / Administradores</title>
  <!-- Favicon -->
  <link rel="shortcut icon" href="" type="image/x-icon">
  <!-- Font awesome cdn link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <!-- Custom css file link  -->
  <link rel="stylesheet" href="./css//main.css">
</head>

<body>
  <!-- Admin accounts section starts -->
  <section class="accounts">
    <h1 class="heading">Cuentas de administrador</h1>
    <div class="box-container">
      <div class="box">
        <p>Agregar nuevo administrador</p>
        <a href="registro_admin.php" class="option-btn">registrar administrador</a>
      </div>

      <?php
      $select_accounts = $connect->prepare("SELECT * FROM `administrativo`");
      $select_accounts->execute();
      if($select_accounts->rowCount() > 0){
        while($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)){   
      ?>
      <div class="box">
        <img src="images_cargadas/<?= $fetch_accounts['Foto']; ?>" alt="" width="100">
        <p> Nombre administrador: <span><?= $fetch_accounts['Nombre']; ?></span> </p>
        <div class="flex-btn">
          <a href="update_profile.php?delete=<?= $fetch_accounts['IdAmin']; ?>"
            onclick="return confirm('¿Quieres eliminar esta cuenta?')" class="delete-btn">Eliminar</a>
          <?php
            if($fetch_accounts['IdAmin'] == $admin_id){
              echo '<a href="update_profile.php" class="option-btn">Actualizar</a>';
            }
          ?>
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
    include './components/footer.php';
  ?>
  <!-- Custom js file link -->
  <script src="./js//main.js"></script>
</body>

</html>