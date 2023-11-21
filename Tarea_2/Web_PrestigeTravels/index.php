
<?php
  session_start();

  require 'prestigetravels.php';
  $global = 0;

  $_SESSION['global'] = $global ;
  $_SESSION['ofertaAceptada'] = "";


  if (isset($_SESSION['user_id'])) {
    $records = $conexion->prepare('SELECT * FROM usuario WHERE rut = :id');
    $records->bindParam(':id', $_SESSION['user_id']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);
    $user = null;
    if (count($results) > 0) {
      $user = $results;
    }
  }
?>

<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">
<head>
  <meta charset="utf-8">
  <title>Bienvenido a PrestigeTravels</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel = "stylesheet" href = "./css/bootstrap.min.css"/>
  <link rel="icon" type="image/png" href="img\logop.png">
</head>

<body>
  <nav class="navbar navbar-expand-l">
    <ul class="nav navbar-nav">
        <li class="nav-item active">
          <a href="inicio.php" ><img class="card-img" src="img\logopb.png"></a>

        </li>

    </ul>
  </nav>


  <?php if(!empty($user)): ?>
    <div style="text-align:center"
      <br> Bienvenido <?= $user['nombre']; ?>
      <br>Ingresaste correctamente a tu cuenta
      <a href="logout.php">
        Logout
      </a>
  </div>
  <?php else: ?>
    <div style="text-align:center">
      <h1 >Inicia sesion o crea tu perfil:</h1>
      <a href="login.php" > Inicia Sesion</a> o
      <a href="registro.php" > Crear una cuenta</a>
    </div>
  <?php endif ?>

</body>
</html>