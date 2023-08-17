<?php
include '../../includes/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
  header('location:../admin/admin_login.php');
};

/* if(isset($_GET['delete'])){
 
} */
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
  <title>Admin Panel / Aula Registradas</title>
  <!-- Favicon -->
  <link rel="shortcut icon" href="" type="image/x-icon">
  <!-- Font awesome cdn link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <!-- Custom css file link  -->
  <link rel="stylesheet" href="../../assets/css//main.css">
</head>

<body>
  <!-- Admin accounts section starts -->
  <section class="accounts">
    <h1 class="heading">Aulas Registradas</h1>
    <div class="box-container">
      <div class="box">
        <?php 
          $select_admins = $connect->prepare("SELECT * FROM `aula`");
          $select_admins->execute();
          $number_of_admins = $select_admins->rowCount();
        ?>
        <p>Aulas agregadas hasta el momento</p>
        <p><?= $number_of_admins; ?></p>
        <a href="registro_aula.php" class="option-btn">registrar aula</a>
      </div>
    </div>
  </section>
  <!-- Admin accounts section ends -->

  <section class="display__product-table">
    <table>
      <thead>
        <th>Número Aula</th>
        <th>Capasidad</th>
        <th>Tipo</th>
        <th>Materias</th>
        <th>Acción</th>
      </thead>

      <tbody>
        <?php
          $show_aula = $connect->prepare("SELECT * FROM `aula`");
          $show_aula->execute();
          if ($show_aula->rowCount() > 0) {
            while ($fetch_aula = $show_aula->fetch(PDO::FETCH_ASSOC)) {
              $materia_id = $fetch_aula['IdMateria'];
              $get_materia = $connect->prepare("SELECT NombreMateria FROM `materia` WHERE IdMateria  = :idMateria");
              $get_materia->bindParam(':idMateria', $materia_id);
              $get_materia->execute();
              $materia = $get_materia->fetch(PDO::FETCH_ASSOC);
          ?>
        <tr>
          <td><?php echo $fetch_aula['NúmeroAula']; ?></td>
          <td><?php echo $fetch_aula['Capacidad']; ?></td>
          <td><?php echo $fetch_aula['Tipo']; ?></td>
          <td><?php echo $materia['NombreMateria']; ?></td>
          <td>
            <a href="aulas_profile?delete=<?php echo $fetch_aula['IdAula']; ?>" class="delete-btn"
              onclick="return confirm('¿Estás seguro de que quieres eliminar esto?');"> <i class="fas fa-trash"></i></a>

            <a href="aulas_profile?edit=<?php echo $fetch_aula['IdAula']; ?>" class="option-btn"> <i
                class="fas fa-edit"></i></a>
          </td>
        </tr>
        <?php 
              };
            }else{
              echo '<p class="empty">¡Aún no se han añadido Aulas!</p>';
            }
          ?>
      </tbody>
    </table>
  </section>

  <?php
    include '../../includes/footer.php';
  ?>
  <!-- Custom js file link -->
  <script src="../../assets/js/main.js"></script>
</body>

</html>