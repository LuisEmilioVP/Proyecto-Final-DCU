<?php
  include '../../includes/connect.php';
  
  session_start();
  
  $admin_id = $_SESSION['admin_id'];
  
  if (!isset($admin_id)) {
    header('location:../admin/admin_login.php');
  };

  if(isset($_POST['update'])){

    $id= $_POST['id'];

    $name_mate = $_POST['name_mate'];
    $name_mate = filter_var($name_mate, FILTER_SANITIZE_STRING);

    $description = $_POST['description'];
    $description = filter_var($description, FILTER_SANITIZE_STRING);
    
    $teacher = $_POST['teacher'];
    $teacher = filter_var($teacher, FILTER_SANITIZE_STRING);
    
    $aula = $_POST['aula'];
    $aula = filter_var($aula, FILTER_SANITIZE_STRING);

     $update_admin = $connect->prepare("UPDATE `materia` SET NombreMateria = ?, Descripción = ?, IdProfesor = ?, IdAula = ? WHERE IdMateria = ?");
     $update_admin->execute([$name_mate, $description, $teacher, $aula, $id]);

     $message[] = 'Materia actualizado con éxito!';

     header('location:./materias_profile.php');
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel / Actualizar Materia</title>
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
    <h1 class="heading">Actualizar Materias</h1>
    <?php 
    $update_id = $_GET['update'];
    $show_admin = $connect->prepare("SELECT * FROM `materia` WHERE IdMateria  = ?");
    $show_admin->execute([$update_id]);
    
    if ($show_admin->rowCount() > 0) {
      while ($fetch_admin = $show_admin->fetch(PDO::FETCH_ASSOC)) {
    ?>
    <form action="" method="post" enctype="multipart/form-data">

      <input type="hidden" name="id" value="<?= $fetch_admin['IdMateria']; ?>">

      <span>Actualizar Nombre Materia</span>
      <input type="text" name="name_mate" class="box" maxlength="50" placeholder="Ingrese el nombre"
        value="<?= $fetch_admin['NombreMateria']; ?>" required>

      <span>Actualizar Descripción</span>
      <input type="text" name="description" class="box" maxlength="40" placeholder="Ingrese descripón breve"
        value="<?= $fetch_admin['Descripción']; ?>" required>

      <span>Profesor (requerido)</span>
      <select name="teacher" class="box">
        <?php
        $selectedItem = $fetch_admin['IdProfesor'];
        
        $show_profesor = $connect->prepare("SELECT IdProfesor, Nombre FROM `profesor`");
        $show_profesor->execute();
        
        if ($show_profesor->rowCount() > 0) {
          while ($fetch_profesor = $show_profesor->fetch(PDO::FETCH_ASSOC)) {
            $profeId = $fetch_profesor['IdProfesor'];
            $nombreprofe = $fetch_profesor['Nombre'];
            $selected = ($profeId == $selectedItem) ? 'selected' : '';
            ?>
        <option value="<?php echo $profeId; ?>" <?php echo $selected; ?>>
          <?php echo $nombreprofe; ?>
        </option>
        <?php
          }
        } else {
          echo '<option disabled>Profesores no disponibles</option>';
        }
      ?>
      </select>

      <span>Estudiante (requerido)</span>
      <select name="aula" class="box">
        <?php
        $selectedItem = $fetch_admin['IdAula'];
        
        $show_aula = $connect->prepare("SELECT IdAula, NúmeroAula FROM `aula`");
        $show_aula->execute();
        
        if ($show_aula->rowCount() > 0) {
          while ($fetch_aula = $show_aula->fetch(PDO::FETCH_ASSOC)) {
            $aulaId = $fetch_aula['IdAula'];
            $numeroAula = $fetch_aula['NúmeroAula'];
            $selected = ($aulaId == $selectedItem) ? 'selected' : '';
            ?>
        <option value="<?php echo $aulaId; ?>" <?php echo $selected; ?>>
          <?php echo $numeroAula; ?>
        </option>
        <?php
          }
        } else {
          echo '<option disabled>Aulas no disponibles</option>';
        }
      ?>
      </select>

      <div class="flex-btn">
        <input type="submit" name="update" value="Actualizar" class="btn">
        <a href="materias_profile.php" class="option-btn">Regresar</a>
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