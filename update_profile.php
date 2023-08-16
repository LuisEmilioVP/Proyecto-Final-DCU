<?php
  include './components/connect.php';
  
  session_start();
  
  $admin_id = $_SESSION['admin_id'];
  
  if (!isset($admin_id)) {
    header('location:admin_login.php');
  };

  if(isset($_POST['update'])){
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);

    $lastname = $_POST['lastname'];
    $lastname = filter_var($lastname, FILTER_SANITIZE_STRING);

    $gender = $_POST['gender'];
    $gender = filter_var($gender, FILTER_SANITIZE_STRING);

    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);

    $phone = $_POST['phone'];
    $phone = filter_var($phone, FILTER_SANITIZE_STRING);

    $post = $_POST['post'];
    $post = filter_var($post, FILTER_SANITIZE_STRING);

     $update_admin = $connect->prepare("UPDATE `administrativo` SET Nombre = ?, Apellido = ?, Genero = ?, Correo = ?, Telefono = ?, Cargo = ? WHERE IdAmin = ?");
     $update_admin->execute([$name, $lastname, $gender, $email, $phone, $post, $admin_id]);

     $message[] = 'Administrador actualizado con éxito!';

    $old_admin_image = $_POST['old_admin_image'];
    $admin_image = $_FILES['admin_image']['name'];
    $admin_image = filter_var($admin_image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['admin_image']['size'];
    $image_tmp_name = $_FILES['admin_image']['tmp_name'];
    $image_folder = 'images_cargadas/'.$admin_image;

    if(!empty($admin_image)){
      if($image_size > 2000000){
        $message[] = '¡El tamaño de la imagen es demasiado grande!';
      }else{
        $update_image = $connect->prepare("UPDATE `administrativo` SET Foto = ? WHERE IdAmin = ?");
        $update_image->execute([$admin_image, $admin_id]);
        move_uploaded_file($image_tmp_name, $image_folder);
        unlink('images_cargadas/'.$old_admin_image);
        $message[] = '¡Imagen actualizada con éxito!';
      }
    };
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel / Actualizar Perfil</title>
  <!-- Favicon -->
  <link rel="shortcut icon" href="" type="image/x-icon">
  <!-- Font awesome cdn link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <!-- Custom css file link  -->
  <link rel="stylesheet" href="./css/main.css">
</head>

<body>

  <?php 
    include './components/header.php';
  ?>

  <!-- Update products section starts -->
  <section class="update-product">
    <h1 class="heading">Actualizar Administrador</h1>
    <?php 
    $update_id = $_GET['update'];
    $show_admin = $connect->prepare("SELECT * FROM `administrativo` WHERE IdAmin = ?");
    $show_admin->execute([$update_id]);
    
    if ($show_admin->rowCount() > 0) {
      while ($fetch_admin = $show_admin->fetch(PDO::FETCH_ASSOC)) {
    ?>
    <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="old_admin_image" value="<?= $fetch_admin['Foto']; ?>">

      <div class="image-container">
        <div class="main-image">
          <img src="images_cargadas/<?= $fetch_admin['Foto']; ?>" alt="">
        </div>
      </div>

      <span>Actualizar Nombre</span>
      <input type="text" name="name" class="box" maxlength="100" placeholder="Ingrese el nombre"
        value="<?= $fetch_admin['Nombre']; ?>" required>

      <span>Actualizar Apellido</span>
      <input type="text" name="lastname" class="box" maxlength="100" placeholder="Ingrese el nombre el apellido"
        value="<?= $fetch_admin['Apellido']; ?>" required>

      <span>Actualizar Genero</span>
      <select name="gender" class="box" required>
        <option selected disabled><?= $fetch_admin['Genero']; ?></option>
        <option value="Masculino">Masculino</option>
        <option value="Femenino">Femenino</option>
      </select>

      <div class="inputBox">
        <span>Actualizar Cargo</span>
        <select name="post" class="box" required>
          <option selected disabled><?= $fetch_admin['Cargo']; ?></option>
          <option value="Administrador">Administrador</option>
          <option value="Supervisor">Supervisor</option>
        </select>
      </div>

      <span>Actualizar Correo</span>
      <input type="text" name="email" class="box" maxlength="100" placeholder="Ingrese el correo"
        value="<?= $fetch_admin['Correo']; ?>" required>

      <span>Actualizar Teléfono</span>
      <input type="text" name="phone" class="box" maxlength="100" placeholder="Ingrese el correo"
        value="<?= $fetch_admin['Telefono']; ?>" required>

      <span>Actualizar Foto</span>
      <input type="file" name="admin_image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp">
      <div class="flex-btn">
        <input type="submit" name="update" value="Actualizar" class="btn">
        <a href="registro_admin.php" class="option-btn">Regresa</a>
      </div>
    </form>
    <?php 
      }
      }else{
        echo '<p class="empty">¡Aún no se han añadido Administradores!</p>';
      }
    ?>
  </section>
  <!-- Update products section ends -->

  <?php
  include './components/footer.php';
  ?>
  <!-- Custom js file link -->
  <script src="./js/main.js"></script>
</body>

</html>