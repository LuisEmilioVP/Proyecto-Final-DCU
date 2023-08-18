<?php
include '../../includes/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
  header('location:../admin/admin_login.php');
};

if(isset($_POST['add_mate'])){
  $name = $_POST['name'];
  $name = filter_var($name, FILTER_SANITIZE_STRING);

  $description = $_POST['description'];
  $description = filter_var($description, FILTER_SANITIZE_STRING);

  $teacher = $_POST['teacher'];
  $teacher = filter_var($teacher, FILTER_SANITIZE_STRING);

  $aula = $_POST['aula'];
  $aula = filter_var($aula, FILTER_SANITIZE_STRING);  

  // Obtener el IdProfesor y IdEstudiante
  $get_profesor_id = $connect->prepare("SELECT IdProfesor FROM `profesor` WHERE Nombre = ?");
  $get_profesor_id->execute([$teacher]);

  $get_aula_id = $connect->prepare("SELECT IdAula FROM `aula` WHERE NúmeroAula = ?");
  $get_aula_id->execute([$aula]);
    
  if ($get_profesor_id->rowCount() > 0 && $get_aula_id->rowCount() > 0 ) {
      $profesor_id = $get_profesor_id->fetch(PDO::FETCH_ASSOC)['IdProfesor'];
      $aula_id = $get_aula_id->fetch(PDO::FETCH_ASSOC)['IdAula'];

      $select_mate = $connect->prepare("SELECT * FROM `materia` WHERE NombreMateria = ?");
      $select_mate->execute([$name]);

      if ($select_mate->rowCount() > 0) {
          $message[] = 'Nombre de materia ya existe!';
      } else {
          $insert_mate = $connect->prepare("INSERT INTO `materia` (NombreMateria, Descripción, IdProfesor, IdAula) VALUES(?,?,?,?)");
          
          $insert_mate->execute([$name, $description, $profesor_id, $aula_id]);
          $message[] = '¡Nueva materia registrada!';
      }
    } else {
        $message[] = 'Profesor o alumno seleccionado no válido!';
    }
    
    header('location:./materias_profile.php');
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
    <h1 class="heading">Agregar Materias</h1>

    <form action="" method="post" enctype="multipart/form-data">
      <div class="flex">
        <div class="inputBox">
          <span>Nombre Materia (requerido)</span>
          <input type="text" name="name" class="box" maxlelegth="50" placeholder="Ingrese el nombre de la materia" required>
        </div>

        <div class="inputBox">
          <span>Descripción (requrida)</span>
          <input type="text" name="description" class="box" maxlegth="40" placeholder="Ingrese descripcion de la materia"
            required>
        </div>

        <div class="inputBox">
          <span>Profesor Asignado (requerido)</span>
          <select name="teacher" class="select">
            <option selected disabled>Seleccione un profesor</option>
            <?php
              $show_profesor = $connect->prepare("SELECT Nombre FROM `profesor`");
              $show_profesor->execute();
              if ($show_profesor->rowCount() > 0) {
              while ($fetch_accounts = $show_profesor->fetch(PDO::FETCH_ASSOC)) {
                $profesor = $fetch_accounts['Nombre'];
            ?>
            <option value="<?php echo $profesor; ?>"><?php echo $profesor; ?></option>
            <?php
            }
          } else {
            echo '<option disabled>No hay Profesores disponibles</option>';
          }
          ?>
          </select>
        </div>

        <div class="inputBox">
          <span>Aula (requerida)</span>
          <select name="aula" class="select">
            <option selected disabled>Seleccione un aula</option>
            <?php
              $show_aula = $connect->prepare("SELECT NúmeroAula FROM `aula`");
              $show_aula->execute();
              if ($show_aula->rowCount() > 0) {
              while ($fetch_accounts = $show_aula->fetch(PDO::FETCH_ASSOC)) {
                // Aquí obtenemos los datos de la tabla "materia"
                $aula = $fetch_accounts['NúmeroAula'];
            ?>
            <option value="<?php echo $aula; ?>"><?php echo $aula; ?></option>
            <?php
            }
          } else {
            echo '<option disabled>No hay Aulas disponibles</option>';
          }
          ?>
          </select>
        </div>

        <input type="submit" value="Agregar materia" class="btn" name="add_mate">
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