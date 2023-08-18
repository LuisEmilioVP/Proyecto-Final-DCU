<?php
include '../../includes/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
  header('location:../admin/admin_login.php');
};

if (isset($_GET['delete'])) {
    $aula_id = $_GET['delete'];

    $delete_aula = $connect->prepare("DELETE FROM `materia` WHERE IdMateria  = ?");
    $delete_aula->execute([$aula_id]);

    header('location:materias_profile.php');
    exit();
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
  <title>Admin Panel / Materias Registradas</title>
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
    <h1 class="heading">Materias Registradas</h1>
    <div class="box-container">
      <div class="box">
        <?php 
          $select_admins = $connect->prepare("SELECT * FROM `materia`");
          $select_admins->execute();
          $number_of_admins = $select_admins->rowCount();
        ?>
        <p>Materias Agregadas</p>
        <p><?= $number_of_admins; ?></p>
        <a href="registro_materia.php" class="option-btn">Registrar Materia</a>
      </div>
      <div class="box">
        <?php 
          $select_students = $connect->prepare("SELECT * FROM `estudiante`");
          $select_students->execute();
          $number_of_students = $select_students->rowCount();
        ?>
        <p>Estudiantes Registrados</p>
        <p><?= $number_of_students; ?></p>
        <a href="estudiante_materia.php" class="option-btn">Agregar Estudiante</a>
      </div>
    </div>
  </section>
  <!-- Admin accounts section ends -->

  <section class="display__product-table">
    <table>
      <thead>
        <th>Materia</th>
        <th>Descripción</th>
        <th>Profesor Asignado</th>
        <th>Aula</th>
        <th>Alumnos Registrados</th>
        <th>Acción</th>
      </thead>

      <tbody>
        <?php
          $select_accounts = $connect->prepare("SELECT * FROM `materia`");
          $select_accounts->execute();
          if($select_accounts->rowCount() > 0){
          while($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)){
             $profesor_id = $fetch_accounts['IdProfesor'];
              $get_profesor = $connect->prepare("SELECT Nombre FROM `profesor` WHERE IdProfesor  = :IdProfesor");
              $get_profesor->bindParam(':IdProfesor', $profesor_id);
              $get_profesor->execute();
              $profesor = $get_profesor->fetch(PDO::FETCH_ASSOC);

              $aula_id = $fetch_accounts['IdAula'];
              $get_aula = $connect->prepare("SELECT NúmeroAula FROM `aula` WHERE IdAula  = :IdAula");
              $get_aula->bindParam(':IdAula', $aula_id);
              $get_aula->execute();
              $aula= $get_aula->fetch(PDO::FETCH_ASSOC);
        ?>
        <tr>
          <td><?php echo $fetch_accounts['NombreMateria']; ?></td>
          <td><?php echo $fetch_accounts['Descripción']; ?></td>
          <td><?php echo $profesor['Nombre']; ?></td>
          <td><?php echo $aula['NúmeroAula']; ?></td>
          <?php 
          $select_admins = $connect->prepare("SELECT * FROM `estudiante_materia` Where IdMateria = ?");
          $id = $fetch_accounts['IdMateria'];
          $select_admins->execute([$id]);
          $number_of_admins = $select_admins->rowCount();
          ?>
          <td><?= $number_of_admins ?></td>
          <td>
            <a href="materias_profile.php?delete=<?php echo $fetch_accounts['IdMateria']; ?>" class="delete-btn"
              onclick="return confirm('¿Estás seguro de que quieres eliminar esto?');"> <i class="fas fa-trash"></i></a>

            <a href="update_materia.php?update=<?php echo $fetch_accounts['IdMateria']; ?>" class="option-btn"> <i
                class="fas fa-edit"></i></a>
          </td>
        </tr>
        <?php 
              };
            }else{
              echo '<p class="empty">¡Aún no se han añadido Materias!</p>';
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