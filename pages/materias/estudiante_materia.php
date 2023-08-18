<?php
include '../../includes/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
  header('location:../admin/admin_login.php');
};

if(isset($_POST['add_student'])){

  $materia = $_POST['materia'];

  $student = $_POST['student'];

  // Obtener el IdProfesor y IdEstudiante
  $get_student_materia = $connect->prepare("SELECT IdMateria FROM `estudiante_materia` WHERE IdEstudiante = ? And IdMateria = ?");
  $get_student_materia->execute([$student, $materia]);

    
    if ($get_student_materia->rowCount() == 0) {

        $insert_mate = $connect->prepare("INSERT INTO `estudiante_materia` (IdMateria, IdEstudiante) VALUES(?,?)");
          
        $insert_mate->execute([$materia, $student]);
         $message[] = '¡Estudiante registrado en materia!';

    } else {
        $message[] = 'Estudiante se encuentra en la materia';
    }

    //header('location:./materias_profile.php');
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
  <title>Admin Panel / Materias</title>
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
    <h1 class="heading">Agregar Estudiante</h1>

    <form action="" method="post" enctype="multipart/form-data">
      <div class="flex">
        <div class="inputBox">
            <span>Materia (requerida)</span>
            <select name="materia" class="select">
            <option selected disabled>Seleccione una Materia</option>
            <?php  
                $show = $connect->prepare("SELECT IdMateria, NombreMateria FROM `materia`");
                $show->execute();
                
                if ($show->rowCount() > 0) {
                while ($fetch = $show->fetch(PDO::FETCH_ASSOC)) {
                    $Id = $fetch['IdMateria'];
                    $nombre = $fetch['NombreMateria'];
                    $selected = ($Id == $selectedItem) ? 'selected' : '';
            ?>
                <option value="<?php echo $Id; ?>" <?php echo $selected; ?>>
                    <?php echo $nombre; ?>
                </option>
                <?php
                }
                    } else {
                    echo '<option disabled>Materias no disponibles</option>';
                    }
                ?>
          </select>
        </div>

        <div class="inputBox">
          <span>Estudiante (requerido)</span>
          <select name="student" class="select">
            <option selected disabled>Seleccione un Estudiante</option>
            <?php  
                $show = $connect->prepare("SELECT IdEstudiante, Nombre FROM `estudiante`");
                $show->execute();
                
                if ($show->rowCount() > 0) {
                while ($fetch = $show->fetch(PDO::FETCH_ASSOC)) {
                    $Id = $fetch['IdEstudiante'];
                    $nombre = $fetch['Nombre'];
                    $selected = ($Id == $selectedItem) ? 'selected' : '';
            ?>
                <option value="<?php echo $Id; ?>" <?php echo $selected; ?>>
                    <?php echo $nombre; ?>
                </option>
                <?php
                }
                    } else {
                    echo '<option disabled>Estudiantes no disponibles</option>';
                    }
                ?>
          </select>
        </div>

        <input type="submit" value="Agregar Estudiante" class="btn" name="add_student">
        <a href="materias_profile.php" class="option-btn">Regresar</a>
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