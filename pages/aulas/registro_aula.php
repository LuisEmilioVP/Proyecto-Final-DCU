<?php
include '../../includes/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
  header('location:../admin/admin_login.php');
};

if(isset($_POST['add_aula'])){
  $num_aula = $_POST['num_aula'];
  $num_aula = filter_var($num_aula, FILTER_SANITIZE_STRING);

  $ability = $_POST['ability'];
  $ability = filter_var($ability, FILTER_SANITIZE_STRING);

  $type_aula = $_POST['type_aula'];
  $type_aula = filter_var($type_aula, FILTER_SANITIZE_STRING);

  $select_aula = $connect->prepare("SELECT * FROM `aula` WHERE NúmeroAula = ?");
      $select_aula->execute([$num_aula]);

  if ($select_aula->rowCount() > 0) {
      $message[] = 'Número de aula ya existe!';
  } else {
      $insert_aula = $connect->prepare("INSERT INTO `aula`(NúmeroAula, Capacidad, Tipo) VALUES(?,?,?)");
      $insert_aula->execute([$num_aula, $ability, $type_aula]);
      $message[] = '¡Nueva aula registrado!';

      header('location:./aulas_profile.php');
  }
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
  <title>Admin Panel / Aulas</title>
  <!-- Favicon -->
  <link rel="shortcut icon" href="" type="image/x-icon">
  <!-- Font awesome cdn link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <!-- Custom css file link  -->
  <link rel="stylesheet" href="../../assets/css/main.css">
</head>

<body>

  <!-- Add Aula section starts -->
  <section class="add-admin">
    <h1 class="heading">Agregar Aulas</h1>

    <form action="" method="post" enctype="multipart/form-data">
      <div class="flex">
        <div class="inputBox">
          <span>Numero Aula (requerido)</span>
          <input type="text" name="num_aula" class="box" maxlegth="100" placeholder="Ingrese el número de aula"
            required>
        </div>

        <div class="inputBox">
          <span>Capacidad (requerido)</span>
          <input type="text" name="ability" class="box" maxlegth="100" placeholder="Ingrese capacidad del aula"
            required>
        </div>

        <div class="inputBox">
          <span>Tipo (requerido)</span>
          <select name="type_aula" class="select">
            <option selected disabled>Seleccione el tipo de aula</option>
            <option value="Laboratorio">Laboratorio</option>
            <option value="Teórica">Teórica</option>
          </select>
        </div>
        <input type="submit" value="Agregar Aula" class="btn" name="add_aula">
        <a href="aulas_profile.php" class="option-btn">Regresar</a>
      </div>
    </form>
  </section>
  <!-- Add Aula section end -->

  <?php
  include '../../includes/footer.php';
  ?>
  <!-- Custom js file link -->
  <script src="../../assets/js/main.js"></script>
</body>

</html>