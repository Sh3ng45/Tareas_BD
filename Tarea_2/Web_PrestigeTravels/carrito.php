


<?php include("template/head.php");
$ofertaAceptada =$_SESSION['ofertaAceptada'];?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de compras</title>
</head>


<body>
    <div class="container mt-5">
        <h1>Carrito de compras</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            
<?php
    require 'prestigetravels.php';
    require 'bdd.php';
    $id = $_GET['id'];
    $querySQL = $conexion->prepare("SELECT * FROM carrito INNER JOIN hotel ON carrito.codigo_hotel = hotel.codigo_hotel WHERE Usuario = $id");
    $querySQL->execute();
    $carrito = $querySQL->fetchAll(PDO::FETCH_ASSOC);

    $queryPaquete = $conexion->prepare("SELECT * FROM carrito INNER JOIN paquete ON carrito.cod_paquete = paquete.cod_paquete WHERE Usuario = $id");
    $queryPaquete->execute();
    $paquete = $queryPaquete->fetchAll(PDO::FETCH_ASSOC);
    $Total = 0;

    $mergedArray = array_merge($carrito, $paquete);
    
    foreach ($mergedArray as $item) {
        if($item['codigo_hotel'] != null){
            $codigo = $item['codigo_hotel'];
            $cod = 'codigo_hotel';
            $hop = 'hotel';
            $Nombre = $item['nombre_hotel'];
            $Compra = 'Hoteles_comprados';
        }else{$codigo = $item['cod_paquete'];
        $cod = 'cod_paquete';
        $hop = 'paquete';
        $Compra = 'Paquetes_comprados';
        $Nombre = $item['nombre_paquete'];}
        $PrecioIndividual = $item['precio'];
        $Disponibles = $item['disponibles'];
        $cantidad = $item['cantidad'];
        $PrecioTotal = $PrecioIndividual*$cantidad;
        $Total = $Total+$PrecioTotal;
        if ($ofertaAceptada == 1) {
            $descuentoPorcentaje = 10 / 100;
            $nuevoTotal = $Total - ($Total * $descuentoPorcentaje);
        } else {
            $nuevoTotal = $Total;
        }
$boton = (isset($_POST["boton"]))?$_POST["boton"]:"";

switch($boton){
    case "Pagar":
        $pagar = "DELETE FROM `carrito` WHERE Usuario = $id";
        $resultado = mysqli_query($conex, $pagar);

        $pagar = "UPDATE usuario
        SET `$Compra` = CONCAT($Compra, ',', $codigo)
        WHERE `rut` = $id";
        $resultado = mysqli_query($conex, $pagar);
        header("Location:inicio.php");
        break;
    }
?>
            <tbody>
                <tr>
                    <td><?php echo $Nombre ?></td>
                    <td>$<?php echo $PrecioIndividual ?></td>
                    <td><?php echo $cantidad ?></td>
                    <td>$<?php echo $PrecioTotal ?></td>
    
                    <td>
                    <a name ="" id = "" class="btn btn-danger btn-sm btn-eliminar" href="carrito11.php?id=<?php echo $id ?>&cod=<?php echo $codigo?>&servicio=<?php echo $hop?>&disponibles=<?php echo $Disponibles?>&cantidad=<?php echo $cantidad?>" role="button"> Eliminar </a>    
                    </td>                                                   
                
            </tbody>
            <?php } ?>
            <tfoot>
                <tr>
                    <th colspan="3">Total:</th>
                    <td>$<?php echo $nuevoTotal ?? 0?></td>
                </tr>
            </tfoot>
        </table>
        <form method="POST" enctype="multipart/form-data" style="text-align:center">
        <div class="btn-group" role="group" aria-label="">
            <button type="submit" name = "boton"  value="Pagar" class="btn btn-success">Pagar</button>
        </div>
        </form>


</body>
</html>

