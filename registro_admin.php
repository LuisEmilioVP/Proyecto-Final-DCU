<?php
include './components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
  header('location:admin_login.php');
};

if(isset($_POST['add_admin'])){
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
  
  $admin_image = $_FILES['admin_image']['name'];
  $admin_image = filter_var($admin_image, FILTER_SANITIZE_STRING);
  $image_size = $_FILES['admin_image']['size'];
  $image_tmp_name = $_FILES['admin_image']['tmp_name'];
  $image_folder = 'images_cargadas/'.$admin_image;
  
  $pass = sha1($_POST['pass']);
  $pass = filter_var($pass, FILTER_SANITIZE_STRING);
  $cpass = sha1($_POST['cpass']);
  $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

  $select_admin = $connect->prepare("SELECT * FROM `administrativo` WHERE Nombre = ?");
  $select_admin->execute([$name]);
  
  if ($select_admin->rowCount() > 0) {
    $message[] = '¡Nombre de usuario ya existe!';
  }else{
    if ($pass != $cpass){
      $message[] = '¡Confirmar contraseña, no coinciden!';
    }else{
      $insert_admin = $connect->prepare("INSERT INTO `administrativo`(Nombre, Apellido, Genero, Correo, Telefono, Cargo, Foto, Clave) VALUES(?,?,?,?,?,?,?,?)");
      move_uploaded_file($image_tmp_name, $image_folder);

      $insert_admin->execute([$name, $lastname, $gender, $email, $phone, $post, $admin_image, $cpass]);
      $message[] = '¡Nuevo administrador registrado!';
    }
  }
};

if (isset($_GET['delete'])) {
  $delete_id = $_GET['delete'];
  $delete_product_image = $connect->prepare("SELECT * FROM `administrativo` WHERE IdAmin = ?");
  $delete_product_image->execute([$delete_id]);
  
  $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
  unlink('images_cargadas/'.$fetch_delete_image['Foto']);

  $delete_product = $connect->prepare("DELETE FROM `administrativo` WHERE IdAmin = ?");
  $delete_product->execute([$delete_id]);
  
  header('location:registro_admin.php');
};
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
  <title>Admin Panel / Productos</title>
  <!-- Favicon -->
  <link rel="shortcut icon" href="" type="image/x-icon">
  <!-- Font awesome cdn link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <!-- Custom css file link  -->
  <link rel="stylesheet" href="./css/main.css">
</head>

<body>

  <!-- Add Admin section starts -->
  <section class="add-admin">
    <h1 class="heading">Agregar Administrador</h1>

    <form action="" method="post" enctype="multipart/form-data">
      <div class="flex">
        <div class="inputBox">
          <span>Nombre (requerido)</span>
          <input type="text" name="name" class="box" maxlelegth="100" placeholder="Ingrese el nombre del administrador"
            required>
        </div>

        <div class="inputBox">
          <span>Apellido (requrido)</span>
          <input type="text" name="lastname" class="box" maxlelegth="100"
            placeholder="Ingrese el apellido del administrador" required>
        </div>

        <div class="inputBox">
          <span>Género (requrido)</span>
          <select name="gender" class="select">
            <option selected disabled>Seleccione un género</option>
            <option value="Masculino">Masculino</option>
            <option value="Femenino">Femenino</option>
          </select>
        </div>

        <div class="inputBox">
          <span>Cargo (requrido)</span>
          <select name="post" class="select">
            <option selected disabled>Seleccione un cargo</option>
            <option value="Administrador">Administrador</option>
            <option value="Supervisor">Supervisor</option>
          </select>
        </div>

        <div class="inputBox">
          <span>Correo (requrido)</span>
          <input type="text" name="email" class="box" maxlelegth="100" placeholder="Ingrese el correo del administrador"
            required>
        </div>

        <div class="inputBox">
          <span>Teléfono (requrido)</span>
          <input type="text" name="phone" class="box" maxlelegth="100"
            placeholder="Ingrese el teléfono del administrador" required>
        </div>

        <div class="inputBox">
          <span>Contraseña (requerido)</span>
          <input type="password" name="pass" required placeholder="Ingresa tu contraseña" maxlength="20" class="box"
            oninput="this.value = this.value.replace(/\s/g, '')">
        </div>

        <div class="inputBox">
          <span>Confirmar Contraseña (requerido)</span>
          <input type="password" name="cpass" required placeholder="Por Favor confirmar contraseña" maxlength="20"
            class="box" oninput="this.value = this.value.replace(/\s/g, '')">
        </div>

        <div class="inputBox">
          <span>Foto (requerido)</span>
          <input type="file" name="admin_image" accept="image/jpg, image/jpeg, image/png, image/webp" class="box"
            required>
        </div>

        <input type="submit" value="Agregar Administrador" class="btn" name="add_admin">
      </div>
    </form>
  </section>
  <!-- Add Admin section end -->

  <!-- Show products section starts -->
  <section class="show-admin">
    <h1 class="heading">Administradores Agregados</h1>
    <div class="box-container">
      <?php 
        $show_admin = $connect->prepare("SELECT * FROM `administrativo`");
        $show_admin->execute();
        if ($show_admin->rowCount() > 0) {
          while ($fetch_admin = $show_admin->fetch(PDO::FETCH_ASSOC)) {
      ?>
      <div class="box">
        <img src="images_cargadas/<?= $fetch_admin['Foto']; ?>" alt="">
        <div class="name"><span><?= $fetch_admin['Nombre']; ?></span></div>
        <div class="lastname"><?= $fetch_admin['Apellido']; ?></div>
        <div class="details"><span><?= $fetch_admin['Genero']; ?></span></div>
        <div class="details"><span><?= $fetch_admin['Correo']; ?></span></div>
        <div class="details"><span><?= $fetch_admin['Telefono']; ?></span></div>

        <div class="flex-btn">
          <?php
            if($fetch_admin['IdAmin'] == $admin_id){
              echo '<a href="update_profile.php" class="option-btn">Actualizar</a>';
            }
          ?>

          <a href="registro_admin.php?delete=<?= $fetch_admin['IdAmin']; ?>" class="delete-btn"
            onclick="return confirm('¿Estas seguro de eliminar este producto?');">Eliminar</a>
        </div>
      </div>
      <?php 
          }
        }else{
          echo '<p class="empty">¡Aún no se han añadido productos!</p>';
        }
      ?>
    </div>
  </section>
  <!-- Show products section ands -->
  <?php
  include './components/footer.php';
  ?>
  <!-- Custom js file link -->
  <script src="./js/main.js"></script>
</body>

</html>