<?php include("template/head.php"); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist</title>
</head>

<?php
    require 'prestigetravels.php';
    require 'bdd.php';
    $id = $_GET['id'];
    $querySQL = $conexion->prepare("SELECT * FROM wishlist INNER JOIN hotel ON wishlist.Hotel = hotel.codigo_hotel WHERE Usuario = $id");
    $querySQL->execute();
    $hotel = $querySQL->fetchAll(PDO::FETCH_ASSOC);

    

    
    $queryPaquete = $conexion->prepare("SELECT * FROM wishlist INNER JOIN paquete ON wishlist.Paquetes = paquete.cod_paquete WHERE Usuario = $id");
    $queryPaquete->execute();
    $paquete = $queryPaquete->fetchAll(PDO::FETCH_ASSOC);

    
    ?>

    <body>
        <div class="container mt-5">
            <h1>Wishlist</h1>
            <table class="table">

    <?php if ($hotel == NULL && $paquete == NULL): ?>

    <thead>
        <tr>
            <th></th>
            <th>No hay elementos en tu Wishlist!</th>
            <th></th>
        </tr>
    </thead>

    <?php else: ?>
        <thead>
            <tr>
                <th></th>
                <th>Elemento</th>
                <th>Puntuación promedio</th>
                <th></th>
            </tr>
        </thead>

        <?php
        $mergedArray = array_merge($hotel, $paquete);
        $array = [];

        foreach ($mergedArray as $item) {
            if ($item['Hotel'] != null) {
                $codigo = $item['codigo_hotel'];
                $cod = 'Hotel';
                $Nombre = $item['nombre_hotel'];
                $Puntuacion = ($item['calidad_limpieza'] + $item['calidad_servicio'] + $item['calidad_decoracion'] + $item['calidad_camas'])/4;
            } else {
                $codigo = $item['cod_paquete'];
                $cod = 'Paquetes';
                $Nombre = $item['nombre_paquete'];
                $Puntuacion = ($item['calidad_hoteles'] + $item['calidad_transporte'] + $item['calidad_servicio'] + $item['rel_calidad-precio'])/4;
                /* 
                $select = $conexion->prepare("SELECT * FROM hotel RIGHT JOIN paquete ON ('" . $item['hospedaje1'] . "' = hotel.codigo_hotel OR '" . $item['hospedaje2'] . "' = hotel.codigo_hotel OR '" . $item['hospedaje3'] . "' = hotel.codigo_hotel) WHERE cod_paquete = '$codigo'");
                $select->execute();
                $paqhotel = $select->fetchAll(PDO::FETCH_ASSOC);
                $longitud = count($paqhotel);
                $Puntuacion = $paqhotel[0]['#Estrellas'];
                if ($longitud == 2) {
                    if ($paqhotel[1] != null) {
                        $Puntuacion = ($paqhotel[0]['#Estrellas'] + $paqhotel[1]['#Estrellas']) / 2;
                    }
                } elseif ($longitud == 3) {
                    if ($paqhotel[2] != null) {
                        $Puntuacion = ($paqhotel[0]['#Estrellas'] + $paqhotel[1]['#Estrellas'] + $paqhotel[2]['#Estrellas']) / 3;
                    }
                }
                */
            }
            $Imagen = $item['imagen'];
            $array[] = $Puntuacion;
        ?>

        <tbody>
            <tr>
                <td><img class="img-thumbnail rounded" src="./img/<?php echo $Imagen; ?>" width="100" alt=""></td>
                <?php if ($cod == 'Hotel'): ?>
                    <td><?php echo "<a href='detallesHotel.php?id=$codigo'>{$Nombre}</a>" ?></td>
                <?php endif ?>
                <?php if ($cod == 'Paquetes'): ?>
                    <td><?php echo "<a href='detallePaquete.php?id=$codigo'>{$Nombre}</a>" ?></td>
                <?php endif ?>
                <td><?php echo $Puntuacion ?></td>
                <td>
                    <a name="" id="" class="btn btn-warning" href="eliminarwishlist.php?id=<?php echo $id ?>&cod=<?php echo $codigo ?>&servicio=<?php echo $cod ?>" role="button"> Eliminar de tu Wishlist </a>
                </td>
            </tr>
        </tbody>

        <?php } ?>

        <?php 
            if (count($array) > 0):
                $suma = 0;
                $cantidad = count($array);
            
                foreach ($array as $puntos) {
                    $suma += $puntos;
                }
                $promedio = $suma / $cantidad;
        ?>

        </table>
        <tfoot>
        <tr>
            <th>Promedio de puntuaciones:<?php echo"  ".$promedio?></th>
        </tr>
        </tfoot>

        <?php endif ?>

        <?php endif ?>    
        
    </div>
</body>
</html>