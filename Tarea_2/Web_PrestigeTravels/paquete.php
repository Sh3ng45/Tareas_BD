<?php include("template/head.php"); ?> 

<?php
include("prestigetravels.php");
$querySQL = $conexion->prepare("SELECT * FROM hotel RIGHT JOIN paquete ON (paquete.hospedaje1 = hotel.codigo_hotel OR paquete.hospedaje2 = hotel.codigo_hotel OR paquete.hospedaje3 = hotel.codigo_hotel)");
$querySQL->execute();
$listapaquetes = $querySQL->fetchAll(PDO::FETCH_ASSOC);
$a = "";
?>

<?php foreach($listapaquetes as $paquete){?>
<?php 
if($a != $paquete['nombre_paquete']):
$longitud = count($paquete);
if($longitud == 2){
    if($paquete!= null){
        $ciudad = $paquete['Ciudad']." y ".$paquete['Ciudad'];
    }
}elseif($longitud == 3){    
    if($paquete != null){
    $ciudad = $paquete['Ciudad'].", ".$paquete['Ciudad']." y ".$paquete['Ciudad'];
}}else{$ciudad = $paquete['Ciudad'];}?>
<div class="col-md-3">
<div class="card">
<img class="img-thumbnail rounded" src="./img/<?php echo $paquete['imagen'];?>" width = "500" alt="">
<div class="card-body">
    <h4 class="card-title"><?php echo $paquete['nombre_paquete'];?></h4>
    <h6 class="card-title">precio por persona: $<?php echo $paquete['precio'];?></h6>
    <h6 class="card-title">noches totales: <?php echo $paquete['noches_totales'];?></h6>
    <h6 class="card-title">noches totales: <?php echo $paquete['noches_totales'];?></h6>
    <h6 class="card-title">Ciudades: <?php echo $ciudad;?></h6>

    <?php $idd = $paquete['cod_paquete'] ?>
    <p class="card-text"></p>
    <a name ="" id = "" class="btn btn-primary" href="detallePaquete.php?id=<?php echo $idd ?>" role="button"> Ver detalle </a>
</div>
</div>
</div>
<?php endif;
$a =$paquete['nombre_paquete'];
?>
<?php } ?>

