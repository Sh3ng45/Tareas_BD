<?php include("template/head.php"); ?>

<?php
include("prestigetravels.php");
include("bdd.php");
$querypaquete = $conexion->prepare("SELECT p.*, r.promedio AS promedio_reseñas
FROM paquete p
JOIN (
    SELECT cod_paquete, (calificacion1 + calificacion2 + calificacion3 + calificacion4)/4 AS promedio
    FROM reseña
    GROUP BY cod_paquete
) r ON p.cod_paquete = r.cod_paquete
ORDER BY r.promedio DESC;
");
$querypaquete->execute();
$ordenar = $querypaquete->fetchAll(PDO::FETCH_ASSOC);

$i = 0;
foreach($ordenar as $row){?>
<div class="col-md-3">
    <div class="card">
        <img class="img-thumbnail rounded" width="300" src="./img/<?php echo $row['imagen'];?>" alt="">
<div class="card-body">
    <h4 class="card-title"><?php echo $i+1 ?>)<?php echo $row['nombre_paquete'];?></h4>
    <h6 class="card-title">Calificación promedio: <?php echo round($row['promedio_reseñas']);?></h6>
    <?php $idd = $row['cod_paquete'] ?>
    <p class="card-text"></p>
    <a name ="" id = "" class="btn btn-primary" href="detallePaquete.php?id=<?php echo $idd ?>" role="button"> Ver mas </a>
    <?php if(++$i == 10)break; ?>
</div>
</div>
</div>
<?php } ?>