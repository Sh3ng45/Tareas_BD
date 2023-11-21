<?php include("template/head.php"); 
    require 'bdd.php'; ?>
    <form action="" method="get">
    <div class="input-group mb-3">
      <input type="text" name="busqueda" placeholder="Buscador de Hoteles y Paquetes" class="form-control">
      <div class="input-group-append">
        <input type="submit" name="enviar" value="Buscar" class="btn btn-outline-light">
      </div>
    </div>
  
    <div class="row">
      <div class="col-md-4">
        <div class="mb-3">
          <label for="precio">Precio:</label>
          <input type="number" name="precio" id="precio" placeholder="Precio máximo" class="form-control">
        </div>
      </div>
      <div class="col-md-4">
        <div class="mb-3">
          <label for="calificacion">Calificación mínima:</label>
          <input type="number" name="calificacion" id="calificacion" placeholder="Calificación mínima" class="form-control">
        </div>
      </div>
      <div class="col-md-4">
        <div class="mb-3">
          <label for="ciudad">Ciudad:</label>
          <input type="text" name="ciudad" placeholder="Ciudad" class="form-control">
        </div>
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
      if(isset($_GET['precio'])&& !empty($_GET['precio'])){
          $precio = $_GET['precio'];
          $consultaHotel .= " AND `precio` <= $precio";
          $consultaPaquete .= " AND `precio` <= $precio";
      }
      if(isset($_GET['calificacion'])&& !empty($_GET['calificacion'])){
          $calificacion = $_GET['calificacion'];
          
          $consultaHotel .= " AND `#Estrellas` >= $calificacion";
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
      if(isset($_GET['paquetes'])&& !empty($_GET['paquetes'])){
        if($_GET['paquetes'] == 'on'){
            echo$consultaHotel;
            $soloP = 1;
            $querySQL = $conexion->prepare($consultaHotel);
          $querySQL->execute();
          $resultadosH = $querySQL->fetchAll(PDO::FETCH_ASSOC);
        }
    }

      if(isset($_GET['ciudad'])&& !empty($_GET['ciudad'])){
        $ciudad = $_GET['ciudad'];
        if($resultadosH){
            $consultaPaquete .= " AND(";
            foreach($resultadosH as $a){
                $match= $a['codigo_hotel'];
                $consultaPaquete .= " (`hospedaje1` = '$match' OR `hospedaje2` = '$match' OR `hospedaje3` = '$match') OR";
            }
        $consultaPaquete = substr($consultaPaquete, 0, -3);
        $consultaPaquete .= ")";
        }
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
      <?php
      foreach($mergedArray as $resultado){
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
