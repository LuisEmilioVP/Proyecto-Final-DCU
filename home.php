<?php
include './components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

// if (!isset($admin_id)) {
// header('location:admin_login.php');
// }
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
        <a href="#" class="btn">Actualizar Perfil</a>
      </div>

      <div class="box">

        <p>Total de Pedidos</p>
        <a href="pedidos_puestos.php" class="btn">Ver pedidos</a>
      </div>

      <div class="box">

        <p>Pedidos Completados</p>
        <a href="pedidos_puestos.php" class="btn">Ver pedidos</a>
      </div>

      <div class="box">

        <p>Pedidos Realizados</p>
        <a href="pedidos_puestos.php" class="btn">Ver pedidos</a>
      </div>

      <div class="box">

        <p>Productos Agregados</p>
        <a href="productos.php" class="btn">Ver Productos</a>
      </div>

      <div class="box">

        <p>Usuarios normales</p>
        <a href="cuentas_usuarios.php" class="btn">Ver Usuarios</a>
      </div>

      <div class="box">

        <p>Usuarios Administradores</p>
        <a href="admin_cuentas.php" class="btn">Ver Administradores</a>
      </div>

      <div class="box">

        <p>Nuevos Mensajes</p>
        <a href="mensajes.php" class="btn">Ver Mensajes</a>
      </div>
    </div>
  </section>
  <!-- Admin dashboard section end -->
  <!-- Custom js file link -->
  <script src="./js/main.js"></script>
</body>

</html>