<?php
include './components/connect.php';

session_start();

/* User and Password default: Juan, 12345 */
if(isset($_POST['submit'])){
  $name = $_POST['name'];
  $name = filter_var($name, FILTER_SANITIZE_STRING);
  $pass = sha1($_POST['pass']);
  $pass = filter_var($pass, FILTER_SANITIZE_STRING);

  $select_admin = $connect->prepare("SELECT * FROM `administrativo` WHERE Nombre = ? AND Clave = ?");
  $select_admin->execute([$name, $pass]);

  if ($select_admin->rowCount() > 0) {
    $fetch_admin_id = $select_admin->fetch(PDO::FETCH_ASSOC);
    $_SESSION['admin_id'] = $fetch_admin_id['IdAmin'];
    header('location:home.php');
  }else{
    $message[] = '¡Nombre de usuario o contraseña incorrecta!';
  }
};
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel / Iniciar sección</title>
  <!-- Favicon -->
  <link rel="shortcut icon" href="" type="image/x-icon">
  <!-- Font awesome cdn link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <!-- Custom css file link  -->
  <link rel="stylesheet" href="./css/main.css">
</head>

<body>
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

  <!-- Admin login form section start -->
  <section class=" form-container">
    <form action="" method="post">
      <h3>Iniciar sesión nueva</h3>
      <p>Ingrese los datos para ingresar al tablero de <span> administración</span> de <span>SoftSchool</span></p>

      <input type="text" name="name" class="box" placeholder="Ingrese su nombre de usuario" maxlength="20" required
        oninput="this.value = this.value.replace(/\s/g, '')">

      <input type="password" name="pass" required placeholder="Ingresa tu contraseña" maxlength="20" class="box"
        oninput="this.value = this.value.replace(/\s/g, '')">

      <input type="submit" value="Inicia sesión" class="btn" name="submit">
    </form>
  </section>
  <!-- Admin login form section end -->

  <!-- Custom js file link -->
  <script src="./js/main.js"></script>
</body>

</html>