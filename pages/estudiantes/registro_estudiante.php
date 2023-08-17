<?php
include '../../includes/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
  header('location:../admin/admin_login.php');
};

if(isset($_POST['add_estudiante'])){
  $name = $_POST['name'];
  $name = filter_var($name, FILTER_SANITIZE_STRING);

  $lastname = $_POST['lastname'];
  $lastname = filter_var($lastname, FILTER_SANITIZE_STRING);

  $gender = $_POST['gender'];
  $gender = filter_var($gender, FILTER_SANITIZE_STRING);

  $age= $_POST['age'];
  $direction = $_POST['direction'];

  $email = $_POST['email'];
  $email = filter_var($email, FILTER_SANITIZE_STRING);

  $phone = $_POST['phone'];
  $phone = filter_var($phone, FILTER_SANITIZE_STRING);

  $estudiante_image = $_FILES['estudiante_image']['name'];
  $estudiante_image = filter_var($estudiante_image, FILTER_SANITIZE_STRING);
  $image_size = $_FILES['estudiante_image']['size'];
  $image_tmp_name = $_FILES['estudiante_image']['tmp_name'];
  $image_folder = '../../assets/images_cargadas/'.$estudiante_image;


  $select_admin = $connect->prepare("SELECT * FROM `estudiante` WHERE Nombre = ?");
  $select_admin->execute([$name]);
  
  if ($select_admin->rowCount() > 0) {
    $message[] = '¡Estudiante ya existe!';
  }else{
    $insert_admin = $connect->prepare("INSERT INTO `estudiante` (`Nombre`, `Apellido`, `Genero`, `Edad`, `Correo`, `Telefono`, `Direccion`, `Foto`) VALUES(?,?,?,?,?,?,?,?)");
    move_uploaded_file($image_tmp_name, $image_folder);

    $insert_admin->execute([$name, $lastname, $gender, $age, $email, $phone, $direction, $estudiante_image]);
    $message[] = '¡Nuevo estudiante registrado!';
  }
};

if (isset($_GET['delete'])) {
  $delete_id = $_GET['delete'];
  $delete_product_image = $connect->prepare("SELECT * FROM `estudiante` WHERE IdEstudiante = ?");
  $delete_product_image->execute([$delete_id]);
  
  $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
  unlink('../../assets/images_cargadas/'.$fetch_delete_image['Foto']);

  $delete_product = $connect->prepare("DELETE FROM `estudiante` WHERE IdEstudiante = ?");
  $delete_product->execute([$delete_id]);
  
  header('location:../registro_estudiante.php');
};
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
  <title>Admin Panel / estudiantes</title>
  <!-- Favicon -->
  <link rel="shortcut icon" href="" type="image/x-icon">
  <!-- Font awesome cdn link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <!-- Custom css file link  -->
  <link rel="stylesheet" href="../../assets/css/main.css">
</head>

<body>

  <!-- Add Admin section starts -->
  <section class="add-admin">
    <h1 class="heading">Agregar Estudiante</h1>

    <form action="" method="post" enctype="multipart/form-data">
      <div class="flex">
        <div class="inputBox">
          <span>Nombre (requerido)</span>
          <input type="text" name="name" class="box" maxlelegth="100" placeholder="Ingrese el nombre del estudiante"
            required>
        </div>

        <div class="inputBox">
          <span>Apellido (requerido)</span>
          <input type="text" name="lastname" class="box" maxlelegth="100"
            placeholder="Ingrese el apellido del estudiante" required>
        </div>

        <div class="inputBox">
          <span>Género (requerido)</span>
          <select name="gender" class="select">
            <option selected disabled>Seleccione un género</option>
            <option value="Masculino">Masculino</option>
            <option value="Femenino">Femenino</option>
          </select>
        </div>

        <div class="inputBox">
          <span>Edad (requerida)</span>
          <input type="number" name="age" class="box" maxlelegth="100" placeholder="Ingrese la edad del estudiante"
            required>
        </div>

        <div class="inputBox">
          <span>Correo (requerido)</span>
          <input type="text" name="email" class="box" maxlelegth="100" placeholder="Ingrese el correo del estudiante"
            required>
        </div>

        <div class="inputBox">
          <span>Teléfono (requerido)</span>
          <input type="text" name="phone" class="box" maxlelegth="100" placeholder="Ingrese el teléfono del estudiante"
            required>
        </div>

        <div class="inputBox">
          <span>Dirección (requerida)</span>
          <input type="text" name="direction" class="box" maxlelegth="100"
            placeholder="Ingrese la direción del estudiante" required>
        </div>

        <div class="inputBox">
          <span>Foto (requerido)</span>
          <input type="file" name="estudiante_image" accept="image/jpg, image/jpeg, image/png, image/webp" class="box"
            required>
        </div>

        <input type="submit" value="Agregar estudiante" class="btn" name="add_estudiante">
      </div>
    </form>
  </section>
  <!-- Add Admin section end -->
  <?php
  include '../../includes/footer.php';
  ?>
  <!-- Custom js file link -->
  <script src="../../assets/js/main.js"></script>
</body>

</html>