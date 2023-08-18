<?php
  include '../../includes/connect.php';
  
  session_start();
  
  $admin_id = $_SESSION['admin_id'];
  
  if (!isset($admin_id)) {
    header('location:../admin/admin_login.php');
  };

  if(isset($_POST['update'])){

    $id= $_POST['id'];

    $num_aula = $_POST['num_aula'];
    $num_aula = filter_var($num_aula, FILTER_SANITIZE_STRING);

    $ability = $_POST['ability'];
    $ability = filter_var($ability, FILTER_SANITIZE_STRING);
    
    $type_aula = $_POST['type_aula'];
    $type_aula = filter_var($type_aula, FILTER_SANITIZE_STRING);
  
     $update_admin = $connect->prepare("UPDATE `aula` SET NúmeroAula = ?, Capacidad = ?, Tipo = ? WHERE IdAula = ?");
     $update_admin->execute([$num_aula, $ability, $type_aula, $id]);

     $message[] = 'Aula actualizado con éxito!';

     header('location:./aulas_profile.php');
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel / Actualizar Aula</title>
  <!-- Favicon -->
  <link rel="shortcut icon" href="" type="image/x-icon">
  <!-- Font awesome cdn link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <!-- Custom css file link  -->
  <link rel="stylesheet" href="../../assets/css/main.css">
</head>

<body>

  <?php 
    include '../../includes/header.php';
  ?>

  <!-- Update products section starts -->
  <section class="update-product">
    <h1 class="heading">Actualizar Aulas</h1>
    <?php 
    $update_id = $_GET['update'];
    $show_admin = $connect->prepare("SELECT * FROM `aula` WHERE IdAula = ?");
    $show_admin->execute([$update_id]);
    
    if ($show_admin->rowCount() > 0) {
      while ($fetch_admin = $show_admin->fetch(PDO::FETCH_ASSOC)) {
    ?>
    <form action="" method="post" enctype="multipart/form-data">

      <input type="hidden" name="id" value="<?= $fetch_admin['IdAula']; ?>">

      <span>Actualizar Número de Aula</span>
      <input type="text" name="num_aula" class="box" maxlength="100" placeholder="Ingrese el nombre"
        value="<?= $fetch_admin['NúmeroAula']; ?>" required>

      <span>Actualizar Capacidad del Aula</span>
      <input type="text" name="ability" class="box" maxlength="100" placeholder="Ingrese el nombre el apellido"
        value="<?= $fetch_admin['Capacidad']; ?>" required>

      <span>Actualizar Tip de Aulao</span>
      <select name="type_aula" class="box" required>
        <option selected disabled><?= $fetch_admin['Tipo']; ?></option>
        <option value="Laboratorio">Laboratorio</option>
        <option value="Teórica">Teórica</option>
      </select>

      <div class="flex-btn">
        <input type="submit" name="update" value="Actualizar" class="btn">
        <a href="aulas_profile.php" class="option-btn">Regresar</a>
      </div>
    </form>
    <?php 
      }
      }else{
        echo '<p class="empty">¡Aún no se han añadido Materias!</p>';
      }
    ?>
  </section>
  <!-- Update products section ends -->

  <?php
  include '../../includes/footer.php';
  ?>
  <!-- Custom js file link -->
  <script src="../../assets/js/main.js"></script>
</body>

</html>