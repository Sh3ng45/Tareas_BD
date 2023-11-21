<?php include("template/head.php");
    require 'prestigetravels.php';
    include("bdd.php"); 
?>


<?php  
if (isset($_SESSION['user_id'])) {     
    $rut = $_SESSION['user_id'];
    $records = $conexion->prepare('SELECT * FROM usuario WHERE rut = :id');     
    $records->bindParam(':id', $_SESSION['user_id']);     
    $records->execute();     
    $results = $records->fetch(PDO::FETCH_ASSOC);      
    $user = null;      
    if (count($results) > 0) {      
         $user = $results;
          }
          
} 


if(isset($_GET['id'])){
    $id = mysqli_real_escape_string($conex,$_GET['id']);

    $select = "SELECT * FROM hotel WHERE codigo_hotel='$id'";
    $resultado = mysqli_query($conex,$select);
    $row = mysqli_fetch_array($resultado);

    $estrellas = $row['#Estrellas'];
    $precio = $row['precio'];
    $Ciudad = $row['Ciudad'];
    $HabitacionesTotales = $row['HabitacionesTotales'];
    $disponibles = $row['disponibles'];
    $Estacionamiento = $row['Estacionamiento'];
    $Piscina = $row['Piscina'];
    $ServicioLavanderia = $row['ServicioLavanderia'];
    $PetFriendly = $row['PetFriendly'];
    $ServicioDesayuno = $row['ServicioDesayuno'];
    $cantidad = 0;

    //Obtiene datos de la tabla carrito
    $querySQL = $conexion->prepare("SELECT * FROM carrito WHERE Usuario = '$rut' AND codigo_hotel = $id");
    $querySQL->execute();
    $carrito =$querySQL->fetchALL(PDO::FETCH_ASSOC);
    if($carrito != null){
        foreach($carrito as $habitacion){
            $cantidad = $habitacion['cantidad'];
            $cantidad =$cantidad+1;
        }
    }


    //Obtiene datos de la tabla wishlist
    $querySQL = $conexion->prepare("SELECT * FROM wishlist WHERE Usuario = '$rut' AND Hotel = $id");
    $querySQL->execute();
    $wishlist =$querySQL->fetchALL(PDO::FETCH_ASSOC);

}
if(!empty($user)):
$null = NULL;
endif;

$boton = (isset($_POST["boton"]))?$_POST["boton"]:"";

switch($boton){
        case "Agregar al Carrito":
            $query = "INSERT INTO `carrito`(`Usuario`, `codigo_hotel`,`cantidad`) VALUES ('$rut','$id','1')";
            $resultado = mysqli_query($conex, $query);
            
            $piezas = $disponibles-1;
            $query = "UPDATE `hotel` SET `disponibles`='$piezas' WHERE `codigo_hotel`='$id'";
            $resultado = mysqli_query($conex, $query);
            header("Location:detallesHotel.php?id={$id}");
            break;
        case "Quitar del carrito":
            $piezas = $disponibles+1;
            $cantidad = $habitacion['cantidad']-1;
            $query1 = "UPDATE `carrito` SET `cantidad`='$cantidad' WHERE `codigo_hotel`='$id' AND `Usuario`='$rut'";
            $resultado1 = mysqli_query($conex, $query1);
            if($cantidad == 0){ 
                $query = "DELETE FROM `carrito` WHERE `Usuario`= '$rut' AND `codigo_hotel` = '$id'";
                $resultado = mysqli_query($conex, $query);
            }
            $query = "UPDATE `hotel` SET `disponibles`='$piezas' WHERE `codigo_hotel`='$id'";
            $resultado = mysqli_query($conex, $query);

            header("Location:detallesHotel.php?id={$id}");
            break;
        case "Reservar otra habitación":
            if($disponibles > 0){
                $cantidadd =$habitacion['cantidad']+1;
                $query = "UPDATE `carrito` SET `cantidad`='$cantidadd' WHERE `codigo_hotel`='$id' AND `Usuario` = '$rut'";
                $resultado = mysqli_query($conex, $query);
                
    
                $piezas = $disponibles-1;
                $query = "UPDATE `hotel` SET `disponibles`='$piezas' WHERE `codigo_hotel`='$id'";
                $resultado = mysqli_query($conex, $query);              
            }else{echo"No Quedan";}//aqui hay q poner alguna wea pa q muestre q no quedan

            header("Location:detallesHotel.php?id={$id}");
            
            break;
        case "Agregar a tu Wishlist": 
            $query = "INSERT INTO `wishlist`(`Usuario`, `Hotel`) VALUES ('$rut','$id')";
            $resultado = mysqli_query($conex, $query);
            header("Location:detallesHotel.php?id={$id}");
            break;
        }
                ?>

<div class="col-md-5">
<div id='container'>

    <h1><?php echo$row['nombre_hotel'] ?></h1>
    <img class="img-thumbnail rounded" src='img/<?php echo$row['imagen']?>' width="400" id='imagen'>
</div>
</div>


<div class="col-md-5">
<br><br><br>
<div class='card'>
<h5><?php echo '<span style="color:#dddddd;text-align:center;">Estrellas: </span>' ?> <?php echo$row['#Estrellas']?> </h5>
<h5><?php echo '<span style="color:#dddddd;text-align:center;">Habitaciones Disponibles: </span>' ?> <?php echo$disponibles?> de <?php echo$row['HabitacionesTotales']?> </h5>
<h5><?php echo '<span style="color:#dddddd;text-align:center;">Precio por noche: </span>' ?> <?php echo$row['precio'] ?></h5>
<h5><?php echo '<span style="color:#dddddd;text-align:center;">Ciudad: </span>' ?> <?php echo$row['Ciudad'] ?></h5>
<h5><?php echo '<span style="color:#dddddd;text-align:center;">Estacionamiento: </span>' ?> <?php
if ($row['Estacionamiento'] == 1) {
    echo "Tiene";
} elseif ($row['Estacionamiento'] == 0) {
    echo "No Tiene";
}
?>
</h5>
<h5><?php echo '<span style="color:#dddddd;text-align:center;">Piscina: </span>' ?> <?php
if ($row['Piscina'] == 1) {
    echo "Tiene";
} elseif ($row['Piscina'] == 0) {
    echo "No Tiene";
}
?></h5>
<h5><?php echo '<span style="color:#dddddd;text-align:center;">Servicio de Lavandería: </span>' ?> <?php
if ($row['ServicioLavanderia'] == 1) {
    echo "Tiene";
} elseif ($row['ServicioLavanderia'] == 0) {
    echo "No Tiene";
}
?></h5>
<h5><?php echo '<span style="color:#dddddd;text-align:center;">PetFriendly: </span>' ?> <?php
if ($row['PetFriendly'] == 1) {
    echo "Si";
} elseif ($row['PetFriendly'] == 0) {
    echo "No";
}
?></h5>
<h5><?php echo '<span style="color:#dddddd;text-align:center;">Servicio de Desayuno: </span>' ?> <?php
if ($row['ServicioDesayuno'] == 1) {
    echo "Tiene";
} elseif ($row['ServicioDesayuno'] == 0) {
    echo "No Tiene";
}
?></h5>
<?php if(!empty($user)): ?>
    <form method="POST" enctype="multipart/form-data" style="text-align:center">
        <div class="btn-group" role="group" aria-label="">
            <?php if($row['disponibles'] > 0 AND $carrito == NULL):?>
            <button type="submit" name = "boton"  value="Agregar al Carrito" class="btn btn-success">Agregar al Carrito</button>
            <?php endif ?>
            <?php if($carrito != NULL):?>
            <button type="submit" name = "boton"  value="Quitar del carrito" class="btn btn-warning">Quitar del Carrito</button>
            <button type="submit" name = "boton" value="Reseñar" class="btn btn-info">Reseñar</button>
            <?php endif ?>
            <?php if($carrito != NULL AND $disponibles != 0):?>
            <button type="submit" name = "boton"  value="Reservar otra habitación" class="btn btn-warning">Reservar otra habitación</button>
            <?php endif ?>
            <?php if($wishlist == NULL):?>
                <button type="submit" name = "boton"  value="Agregar a tu Wishlist" class="btn btn-success">Agregar a tu Wishlist</button>
            <?php endif ?>
        </div>
    </form>
<?php endif ?>


</div>
</div>

