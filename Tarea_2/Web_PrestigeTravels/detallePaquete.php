<?php include("template/head.php");
    require 'prestigetravels.php';
    include("bdd.php"); 
?>


<?php  
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


if(isset($_GET['id'])){
    $id = mysqli_real_escape_string($conex,$_GET['id']);
    $rut = $_SESSION['user_id'];
    $select = $conexion->prepare("SELECT * FROM hotel RIGHT JOIN paquete ON (paquete.hospedaje1 = hotel.codigo_hotel OR paquete.hospedaje2 = hotel.codigo_hotel OR paquete.hospedaje3 = hotel.codigo_hotel) WHERE cod_paquete='$id'");
    $select->execute();
    $paquetes = $select->fetchAll(PDO::FETCH_ASSOC);
    $ciudad = $paquetes[0]['Ciudad'];
    $hospedaje = $paquetes[0]['nombre_hotel'];
    $longitud = count($paquetes);
    if($longitud == 2){
        if($paquetes[1]!= null){
            $ciudad = $paquetes[0]['Ciudad']." y ".$paquetes[1]['Ciudad'];
            $hospedaje = $paquetes[0]['nombre_hotel']." y ".$paquetes[1]['nombre_hotel'];
        }
    }elseif($longitud == 3){    
        if($paquetes[2] != null){
        $ciudad = $paquetes[0]['Ciudad'].", ".$paquetes[1]['Ciudad']." y ".$paquetes[2]['Ciudad'];
        $hospedaje = $paquetes[0]['nombre_hotel'].", ".$paquetes[1]['nombre_hotel']." y ".$paquetes[2]['nombre_hotel'];
    }}

    $aerolinea_ida = $paquetes[0]['aerolinea_ida'];
    
    $aerolinea_vuelta = $paquetes[0]['aerolinea_vuelta'];
    $fechaSalida = $paquetes[0]['fecha_salida'];
    $fechaLLegada = $paquetes[0]['fecha_llegada'];
    $noches_totales = $paquetes[0]['noches_totales'];
    $precio_persona = $paquetes[0]['precio'];
    $disponibles = $paquetes[0]['disponibles'];
    $max_personas = $paquetes[0]['max_pers_x_paq'];

    //Obtiene datos de la tabla carrito
    $querySQL = $conexion->prepare("SELECT * FROM carrito WHERE Usuario = '$rut' AND cod_paquete = $id");
    $querySQL->execute();
    $carrito =$querySQL->fetchALL(PDO::FETCH_ASSOC);
    if($carrito != null){
        foreach($carrito as $habitacion){
            $cantidad = $habitacion['cantidad'];
            $cantidad =$cantidad+1;
        }
    }

    //Obtiene datos de la tabla wishlist
    $querySQL = $conexion->prepare("SELECT * FROM wishlist WHERE Usuario = '$rut' AND Paquetes = $id");
    $querySQL->execute();
    $wishlist =$querySQL->fetchALL(PDO::FETCH_ASSOC);
}
if(!empty($user)):
$null = NULL;
endif;

$boton = (isset($_POST["boton"]))?$_POST["boton"]:"";

switch($boton){
    case "Agregar al Carrito":
        $query = "INSERT INTO `carrito`(`Usuario`, `cod_paquete`,`cantidad`) VALUES ('$rut','$id','1')";
        $resultado = mysqli_query($conex, $query);

        $piezas = $disponibles-1;
        $query = "UPDATE `paquete` SET `disponibles`='$piezas' WHERE `cod_paquete`='$id'";
        $resultado = mysqli_query($conex, $query);
        header("Location:detallePaquete.php?id={$id}");
        break;
    case "Quitar del carrito":
        $piezas = $disponibles+1;
        $cantidad = $habitacion['cantidad']-1;
        $query1 = "UPDATE `carrito` SET `cantidad`='$cantidad' WHERE `cod_paquete`='$id' AND `Usuario`='$rut'";
        $resultado1 = mysqli_query($conex, $query1);
        if($cantidad == 0){ 
            $query = "DELETE FROM `carrito` WHERE `Usuario`= '$rut' AND `cod_paquete` = '$id'";
            $resultado = mysqli_query($conex, $query);
        }
        $query = "UPDATE `paquete` SET `disponibles`='$piezas' WHERE `cod_paquete`='$id'";
        $resultado = mysqli_query($conex, $query);

        header("Location:detallePaquete.php?id={$id}");
        break;
    case "Reservar otra habitación":
        if($disponibles > 0){
            $cantidadd =$habitacion['cantidad']+1;
            $query = "UPDATE `carrito` SET `cantidad`='$cantidadd' WHERE `cod_paquete`='$id' AND `Usuario` = '$rut'";
            $resultado = mysqli_query($conex, $query);
            

            $piezas = $disponibles-1;
            $query = "UPDATE `paquete` SET `disponibles`='$piezas' WHERE `cod_paquete`='$id'";
            $resultado = mysqli_query($conex, $query);              
        }

        header("Location:detallePaquete.php?id={$id}");
        
        break;

    case "Agregar a tu Wishlist": 
        $query = "INSERT INTO `wishlist`(`Usuario`, `Paquetes`) VALUES ('$rut','$id')";
        $resultado = mysqli_query($conex, $query);
        header("Location:detallePaquete.php?id={$id}");
        break;
    }
?>

<div class="col-md-5">
<div id='container'>

    <h1><?php echo$paquetes[0]['nombre_paquete'] ?></h1>
    <img class="img-thumbnail rounded" src='img/<?php echo$paquetes[0]['imagen']?>' width="400" id='imagen'>
</div>
</div>


<div class="col-md-5">
<br><br><br>
<div class='card'>
<h5><?php echo '<span style="color:#dddddd;text-align:center;">Disfrutaras  </span>' ?> <?php echo$noches_totales+1; echo" Días y "; echo$paquetes[0]['noches_totales']; echo" Noches" ?></h5>
<h5><?php echo '<span style="color:#dddddd;text-align:center;">Aerolinea: </span>' ?> <?php
if ($paquetes[0]['aerolinea_ida'] == $paquetes[0]['aerolinea_vuelta']) {
    echo$paquetes[0]['aerolinea_ida']; 
} else {
    echo"ida: "; echo$paquetes[0]['aerolinea_ida'];  echo" vuelta: ";  echo$paquetes[0]['aerolinea_vuelta'];
}
?> </h5>
<h5><?php echo '<span style="color:#dddddd;text-align:center;">Hospedaje: </span>' ?> <?php echo$hospedaje?></h5>

<h5><?php echo '<span style="color:#dddddd;text-align:center;">Ciudad: </span>' ?> <?php echo$ciudad ?></h5>
<h5><?php echo '<span style="color:#dddddd;text-align:center;">Fechas: </span>' ?> Desde: <?php echo$paquetes[0]['fecha_salida'] ?> Hasta: <?php echo$paquetes[0]['fecha_llegada'] ?> </h5>
<h5><?php echo '<span style="color:#dddddd;text-align:center;">Precio por persona: </span>' ?> $<?php echo$paquetes[0]['precio'] ?></h5>
<h5><?php echo '<span style="color:#dddddd;text-align:center;">Personas máximas: </span>' ?> <?php echo$paquetes[0]['max_pers_x_paq'] ?></h5>
<h5><?php echo '<span style="color:#dddddd;text-align:center;">Apresurate, solo quedan  </span>' ?> <?php echo$paquetes[0]['disponibles'] ?> paquetes!</h5>

<?php if(!empty($user)): ?>
    <form method="POST" enctype="multipart/form-data" style="text-align:center">
        <div class="btn-group" role="group" aria-label="">
            <?php if($disponibles > 0 AND $carrito == NULL):?>
            <button type="submit" name = "boton"  value="Agregar al Carrito" class="btn btn-success">Agregar al Carrito</button>
            <?php endif ?>
            <?php if($carrito != NULL):?>
            <button type="submit" name = "boton"  value="Quitar del carrito" class="btn btn-warning">Quitar del carrito</button>
            <button type="submit" name = "boton" value="Reseñar" class="btn btn-info">Reseñar</button>
            <?php endif ?>
            <?php if($carrito != NULL AND $disponibles != 0):?>
            <button type="submit" name = "boton"  value="Reservar otra habitación" class="btn btn-warning">Reservar otra habitación</button>
            <?php endif ?>
            <?php if($wishlist == NULL):?>
                <button type="submit" name = "boton"  value="Agregar a tu Wishlist" class="btn btn-warning">Agregar a tu Wishlist</button>
            <?php endif ?>
        </div>
    </form>
<?php endif ?>


</div>
</div>