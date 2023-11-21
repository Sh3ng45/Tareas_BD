<?php include("template/head.php"); ?> 
<?php require 'prestigetravels.php';
require 'bdd.php';



$global = $_SESSION['global'];
$ofertaAceptada = $_SESSION['ofertaAceptada'];

if(isset($_POST['oferta_aceptada'])){
    $ofertaAceptada = $_POST['oferta_aceptada'];
}

$_SESSION['ofertaAceptada']=$ofertaAceptada;
if(!$global){
    $mostrarOferta = (rand(1, 100) <= 100);
}else{$mostrarOferta = 0;}



$descuento = 10; // 10% de descuento
//fin codigo descuento?>

<div class="container mt-3">

    <?php if ($mostrarOferta): ?>
        <?php $_SESSION['global'] =1;?> 
        <h4>¡Oferta espontánea!</h4>
        <p>Ahora tienes la oportunidad de obtener un descuento del <?php echo $descuento ?>% en tu compra.</p>
        <form name="Oferta" method="POST" action="">
            <input type="hidden" name="oferta_aceptada" value="1">
            <button type="submit" class="btn btn-primary">Aceptar oferta</button>
            <button type="button" class="btn btn-danger" onclick="rechazarOferta()">Rechazar oferta</button>
        </form>
    <?php endif; ?>
</div>

<script>
    function rechazarOferta() {
        // Enviar el formulario con el campo oferta_aceptada igual a "0"
        document.querySelector('input[name="oferta_aceptada"]').value = "0";
        document.querySelector('form').submit();
        header("Location:inicio.php");
    }
    //fin codigo descuento
</script>
 

<div class="jumbotron d-flex justify-content-center">

    <h1 class="display-3">Bienvenido a PrestigeTravels</h1>
    <p class="lead">Compra paquetes y agenda habitaciones de Hotel.</p>
    <hr class="my-2">
    
    <br>
    
    <div class="container d-flex justify-content-center">
  <div class="row">
    <div class="col-md-6 col-lg-3 mb-4">
      <div class="card border-primary h-100">
        <div class="card-header">Top 10 mejores hoteles</div>
        <div class="card-body">
        <a class ="d-flex justify-content-center" href="top10h.php"><img id="boton1" src="img/top10h.jpg" width="140"/></a>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3 mb-4">
      <div class="card border-primary h-100">
        <div class="card-header">Top 10 mejores paquetes</div>
        <div class="card-body">
        <a class ="d-flex justify-content-center" href="top10p.php"><img id="boton1" src="img/top10p.png" width="100"/></a>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3 mb-4">
      <div class="card border-primary h-100">
        <div class="card-header">Los que tienen mas reservas disponibles</div>
        <div class="card-body">
        <a class ="d-flex justify-content-center" href="mas_disponibles.php"><img id="boton1" src="img/Disponible.png" width="150"/></a>
        </div>
      </div>
    </div>
  </div>
</div>


        <p class="lead">
    </p>
</div>
<br>
<form action="" method="get">
  <div class="input-group mb-3">
    <input type="text" name="busqueda" placeholder="Buscador de Hoteles y Paquetes" class="form-control">
    <div class="input-group-append">
      <input type="submit" name="enviar" value="Buscar" class="btn btn-outline-light">
    </div>
  </div>

    <div class="row">
        <div class="col-sm-2">
        <div class="mb-3">
            <label for="precio">Precio:</label>
            <input type="number" name="precio" id="precio" placeholder="Precio máximo" class="form-control">
        </div>
        </div>
        <div class="col-md-2">
        <div class="mb-3">
            <label for="calificacion">Calificación mínima:</label>
            <input type="number" name="calificacion" id="calificacion" placeholder="Calificación mínima" class="form-control">
        </div>
        </div>
        <div class="col-md-2">
        <div class="mb-3">
            <label for="ciudad">Ciudad:</label>
            <input type="text" name="ciudad" placeholder="Ciudad" class="form-control">
        </div>
        </div>
        <div class="form-check mb-3">
            <input type="checkbox" name="paquetes" id="paquetes" class="form-check-input">
            <label for="paquetes" class="form-check-label">Buscar solo paquetes</label>
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" name="hoteles" id="hoteles" class="form-check-input">
            <label for="hoteles" class="form-check-label">Buscar solo hoteles</label>
        </div>
        <div class="row">
        <div class="col-md-4">
        <div class="mb-3">
            <label for="Fecha+de+Salida">Fecha de Salida:</label>
            <input type="date" name="Fecha+de+Salida" id="Fecha+de+Salida" placeholder="Salida" class="form-control">
        </div>
        </div>
        </div>
        <div class="row">
        <div class="col-md-4">
            <div class="mb-3">
            <label for="Fecha+de+Llegada">Fecha de Llegada:</label>
            <input type="date" name="Fecha+de+Llegada" id="Fecha+de+Llegada" placeholder="Llegada" class="form-control">
            </div>
        </div>
    </div>

    </form>

<br>

<?php
if(isset($_GET['enviar'])){
    $busqueda = $_GET['busqueda'];
    $soloH= 0;
    $soloP= 0;
    // Construir la consulta base
    $consultaHotel = "SELECT * FROM hotel WHERE nombre_hotel LIKE '%$busqueda%'";

    $consultaPaquete = "SELECT * FROM paquete WHERE nombre_paquete LIKE '%$busqueda%'";

    // Aplicar filtros

    if(isset($_GET['Fecha+de+Salida'])&& !empty($_GET['Fecha+de+Salida'])){
        $FechaSalida = $_GET['Fecha+de+Salida'];
    }
    if(isset($_GET['Fecha+de+Llegada'])&& !empty($_GET['Fecha+de+Llegada'])){
        $FechaLlegada = $_GET['Fecha+de+Llegada'];
        $consultaPaquete .= " AND `fecha_llegada` <= '$FechaLlegada' AND `fecha_salida` >= '$FechaSalida'";
    }

    if(isset($_GET['precio'])&& !empty($_GET['precio'])){
        $precio = $_GET['precio'];
        $consultaHotel .= " AND `precio` <= $precio";
        $consultaPaquete .= " AND `precio` <= $precio";
    }
    if(isset($_GET['calificacion'])&& !empty($_GET['calificacion'])){
        $calificacion = $_GET['calificacion'];
        
        $consultaHotel .= " AND `#Estrellas` >= $calificacion";
    }
    if(isset($_GET['paquetes'])&& !empty($_GET['paquetes'])){
        if($_GET['paquetes'] == 'on'){
            $soloP = 1;
        }
    }
    if(isset($_GET['hoteles'])&& !empty($_GET['hoteles'])){
        if($_GET['hoteles'] == 'on'){
            $soloH = 1;
        }
    }
    if(isset($_GET['ciudad'])&& !empty($_GET['ciudad'])){
        $ciudad = $_GET['ciudad'];
        $consultaHotel .= " AND `Ciudad` = '$ciudad'";
    }
    
    if($soloP == 0){
        $querySQL = $conexion->prepare($consultaHotel);
        $querySQL->execute();
        $resultadosH = $querySQL->fetchAll(PDO::FETCH_ASSOC);
    }else($resultadosH=[]);
    if($soloH == 0){
        $querySQL = $conexion->prepare($consultaPaquete);
        $querySQL->execute();
        $resultadosP = $querySQL->fetchAll(PDO::FETCH_ASSOC);
    }else($resultadosP=[]);
    


    $mergedArray = array_merge($resultadosH, $resultadosP);
    ?>
    <table class="table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                </tr>
            </thead>
    <?php foreach($mergedArray as $resultado){
        if(isset($resultado['codigo_hotel']) && $resultado['codigo_hotel'] != null){
            $servicio = 'sHotel';
        }else{$servicio = 'Paquete';}
        ?> 
        
        </tbody>
            <tr>
                <td><img class="img-thumbnail rounded" src='img/<?php echo$resultado['imagen']?>' width="100" alt='Imagen representativa'></td>
                <td><a href='detalle<?php echo $servicio?>.php?id=<?php echo $resultado['codigo_hotel'] ?? $resultado['cod_paquete']?>'><?php echo$resultado['nombre_hotel'] ?? $resultado['nombre_paquete']?></a></td>
                <td>$<?php echo $resultado['precio']?></td>
            </tr>                              
        </tbody>

    <?php }
}
?>
