<?php   
 
require 'prestigetravels.php';
session_start();
if (isset($_SESSION['user_id'])) {     
    $records = $conexion->prepare('SELECT rut, nombre, fecha_nacimiento, email FROM usuario WHERE rut = :id');     
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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PrestigeTravels</title>
    <link rel="icon" type="image/png" href="img\logop.png">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0/js/bootstrap.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="./css/bootstrap.min.css"/>

    <style>
        /* Cambia el color del texto del navbar a blanco */
        .bg-primary{
            background-color: brown;
        }
    </style>
</head>
<body class="">
    <nav class="navbar navbar-dark bg-primary">

        <ul class="nav justify-content-center">
            <li class="nav-item">
                <a href="index.php"><img class="card-img" src="img\logopb.png" ></a>
            </li>
            <li class="nav-item " >
                <a class="nav-link" style="color:#ffffff;text-align:center;" href="inicio.php">Inicio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" style="color:#ffffff;text-align:center;" href="hotel.php">Hoteles</a>
            </li>  
            <li class="nav-item">
                <a class="nav-link" style="color:#ffffff;text-align:center;" href="paquete.php">Paquetes</a>
            </li>    
   
            <?php if(!empty($user)): ?>
            <li class="nav-item d-flex">
                <a class="nav-link" style="color:#ffffff;text-align:center;" href="usuario.php?id=<?php echo$results['rut']?>">Usuario Activo: <?php echo utf8_decode($results['nombre'])?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" style="color:#ffffff;text-align:center;" href="logout.php">cerrar sesion</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" style="color:#ffffff;text-align:center;" href="carrito.php?id=<?php echo$results['rut']?>"> Carrito</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" style="color:#ffffff;text-align:center;" href="wishlist.php?id=<?php echo$results['rut']?>"> Wishlist</a>
            </li>

            <?php else: ?>
            <li class="nav-item d-flex">
                <a class="nav-link" style="color:#ffffff;text-align:center;" href="login.php" > Inicia Sesion</a> 
            </li>
            <li class="nav-item">
                <a class="nav-link" style="color:#ffffff;text-align:center;" href="registro.php" > Crear una cuenta</a>
            </li>
            <?php endif ?>
        </ul>
        <br>
    </nav>





    <div class="container ">
        <br/>
        <div class = "row">