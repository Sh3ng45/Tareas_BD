<?php include("template/head.php"); ?> 

<?php
require 'prestigetravels.php';
$querySQL = $conexion->prepare("SELECT * FROM hotel");
$querySQL->execute();
$listahoteles =$querySQL->fetchALL(PDO::FETCH_ASSOC);
?>

<?php foreach($listahoteles as $hotel){ ?>
<div class="col-md-3">
<div class="card">
<img class="img-thumbnail rounded" src="./img/<?php echo $hotel['imagen'];?>" width = "500" alt="">
<div class="card-body">
    <h4 class="card-title"><?php echo $hotel['nombre_hotel'];?></h4>
    <h6 class="card-title">Ciudad: <?php echo $hotel['Ciudad'];?></h6>
    <h6 class="card-title">Precio: $<?php echo $hotel['precio'];?> clp</h6>
    <h6 class="card-title">Habitaciones disponibles: <?php echo $hotel['disponibles'];?> de <?php echo $hotel['HabitacionesTotales'];?></h6>
    <?php $idd = $hotel['codigo_hotel'] ?>
    <p class="card-text"></p>
    <a name ="" id = "" class="btn btn-primary" href="detallesHotel.php?id=<?php echo $idd ?>" role="button"> Ver mas </a>
</div>
</div>
</div>
<?php } ?>
