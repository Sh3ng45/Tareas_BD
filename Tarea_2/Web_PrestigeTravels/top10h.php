<?php include("template/head.php"); ?>

<?php
include("prestigetravels.php");
include("bdd.php");
$queryhotel = $conexion->prepare("SELECT h.*, r.promedio AS promedio_reseñas
                                FROM hotel h
                                JOIN (
                                    SELECT codigo_hotel, (calificacion1 + calificacion2 + calificacion3 + calificacion4)/4 AS promedio
                                    FROM reseña
                                    GROUP BY codigo_hotel
                                ) r ON h.codigo_hotel = r.codigo_hotel
                                ORDER BY r.promedio DESC;
                                ");
$queryhotel->execute();
$ordenar = $queryhotel->fetchAll(PDO::FETCH_ASSOC);

$i = 0;
foreach($ordenar as $row){?>
<div class="col-md-3">
    <div class="card">
        <img class="img-thumbnail rounded" width="300" src="./img/<?php echo $row['imagen'];?>" alt="">
<div class="card-body">
    <h4 class="card-title"><?php echo $i+1 ?>)<?php echo $row['nombre_hotel'];?></h4>
    <h6 class="card-title">Calificación promedio: <?php echo round($row['promedio_reseñas']);?></h6>
    <?php $idd = $row['codigo_hotel'] ?>
    <p class="card-text"></p>
    <a name ="" id = "" class="btn btn-primary" href="detallesHotel.php?id=<?php echo $idd ?>" role="button"> Ver mas </a>
    <?php if(++$i == 10)break; ?>
</div>
</div>
</div>
<?php } ?>
<?php
/*
foreach ($hotel as $item) {
    $nombre_hotel = $item['nombre_hotel'];
    $puntos_hotel = ($item['calidad_limpieza'] + $item['calidad_servicio'] + $item['calidad_decoracion'] + $item['calidad_camas'])/4;
    $imagen_hotel = $item['imagen'];
    $puntuaciones[] = $puntos_hotel;
}
 */?>