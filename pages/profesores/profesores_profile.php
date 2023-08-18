<?php
include '../../includes/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
  header('location:../admin/admin_login.php');
};

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $delete_product_image = $connect->prepare("SELECT * FROM `profesor` WHERE IdProfesor = ?");
    $delete_product_image->execute([$delete_id]);
    
    $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
    unlink('../../assets/images_cargadas/'.$fetch_delete_image['Foto']);

    $delete_product = $connect->prepare("DELETE FROM `profesor` WHERE IdProfesor = ?");
    $delete_product->execute([$delete_id]);
    
    header('location:./profesores_profile.php');
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
  <title>Admin Panel / Profesores</title>
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
    <h1 class="heading">Profesores</h1>
    <div class="box-container">
      <div class="box">
        <?php 
          $select_admins = $connect->prepare("SELECT * FROM `profesor`");
          $select_admins->execute();
          $number_of_admins = $select_admins->rowCount();
        ?>
        <p>Profesores Agregados</p>
        <p><?= $number_of_admins; ?></p>
        <a href="registro_profesor.php" class="option-btn">registrar profesor</a>
      </div>
    </div>
    <br>
    <br>
    <div class="box-container">
      <?php 
            $show_admin = $connect->prepare("SELECT * FROM `profesor`");
            $show_admin->execute();
            if ($show_admin->rowCount() > 0) {
            while ($fetch_admin = $show_admin->fetch(PDO::FETCH_ASSOC)) {
        ?>
      <div class="box">
        <img src="../../assets/images_cargadas/<?= $fetch_admin['Foto']; ?>" width="100" alt="">
        <p> Nombre: <span><?= $fetch_admin['Nombre'] ." ". $fetch_admin['Apellido']; ?></span> </p>
        <div class="details"><span><?= $fetch_admin['Especialidad']; ?></span></div>
        <div class="details"><span><?= $fetch_admin['Correo']; ?></span></div>
        <div class="details"><span><?= $fetch_admin['Telefono']; ?></span></div>

        <a href="update_profesor.php?update=<?= $fetch_admin['IdProfesor']; ?>" class="option-btn">Actualizar</a>
        <a href="registro_profesor.php?delete=<?= $fetch_admin['IdProfesor']; ?>" class="delete-btn"
          onclick="return confirm('¿Estas seguro de eliminar este producto?');">Eliminar</a>
      </div>
    <?php 
            }
            }else{
            echo '<p class="empty">¡Aún no se han añadido profesores!</p>';
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