<?php
    include("bdd.php");
    include("prestigetravels.php");

    if(isset($_GET['id'], $_GET['cod'], $_GET['servicio'],$_GET['disponibles'],$_GET['cantidad'])){
        $id = $_GET['id'];
        $codigo =$_GET['cod'];
        $servicio = $_GET['servicio'];
        $disponibles = $_GET['disponibles'];
        $cantidad = $_GET['cantidad'];
        if($servicio == 'hotel'){
            $cod = 'codigo_hotel';
        }else{$cod = 'cod_paquete';}
        $piezas = $disponibles+1;
        $cantidad = $_GET['cantidad']-1;
        $query1 = "UPDATE `carrito` SET `cantidad`='$cantidad' WHERE `$cod`='$codigo' AND `Usuario`='$id'";
        $resultado1 = mysqli_query($conex, $query1);
        if($cantidad == 0){ 
            $query = "DELETE FROM `carrito` WHERE `Usuario`= '$id' AND `$cod` = '$codigo'";
            $resultado = mysqli_query($conex, $query);
        }
        $query = "UPDATE `$servicio` SET `disponibles`='$piezas' WHERE `$cod`='$codigo'";
        $resultado = mysqli_query($conex, $query);

        header("Location:carrito.php?id=$id");
        
        }
?>

