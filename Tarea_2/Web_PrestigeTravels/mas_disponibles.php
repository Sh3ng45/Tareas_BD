<?php include("template/head.php"); ?>

<?php
include("prestigetravels.php");
include("bdd.php");


$queryhotel = $conexion->prepare("
  (SELECT cod_paquete AS cod, nombre_paquete AS nombre, disponibles, precio, imagen
    FROM paquete
    ORDER BY disponibles DESC
    LIMIT 4)
  UNION
  (SELECT codigo_hotel AS cod, nombre_hotel AS nombre, disponibles, precio, imagen
    FROM hotel
    ORDER BY disponibles DESC
    LIMIT 4)
  ORDER BY disponibles DESC");


$queryhotel->execute();
$ordenar = $queryhotel->fetchAll(PDO::FETCH_ASSOC);

$i = 0;
foreach($ordenar as $row){ ?>
<div class="col-md-3">
    <div class="card">
        <img class="img-thumbnail rounded" width="300" src="./img/<?php echo $row['imagen'];?>" alt="">
<div class="card-body">
    <h4 class="card-title"><?php echo $i+1 ?>)<?php echo $row['nombre'];?></h4>
    <h6 class="card-title">Precio: <?php echo ($row['precio']);?></h6>
    <h6 class="card-title">Disponibilidad: <?php echo ($row['disponibles']);?></h6>
    <?php $idd = $row['cod'] ?>
    <p class="card-text"></p>
    <?php if (strpos($row['nombre'], "Paquete") !== false): ?>
        <a name ="" id = "" class="btn btn-primary" href="detallePaquete.php?id=<?php echo $idd ?>" role="button"> Ver mas </a>
    <?php else: ?>
        <a name ="" id = "" class="btn btn-primary" href="detallesHotel.php?id=<?php echo $idd ?>" role="button"> Ver mas </a>
    <?php endif ?>
    <?php if(++$i == 4)break; ?>
</div>
</div>
</div>
<?php } ?>






