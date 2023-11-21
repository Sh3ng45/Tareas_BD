<?php
    include("bdd.php");
    include("prestigetravels.php");

    if(isset($_GET['id'], $_GET['cod'], $_GET['servicio'])){
        $id = $_GET['id'];
        $codigo =$_GET['cod'];
        $servicio = $_GET['servicio'];
        
        $eliminar = "DELETE FROM `wishlist` WHERE `Usuario`= '$id' AND `$servicio` = '$codigo'";
        $resultado = mysqli_query($conex, $eliminar);

        header("Location:wishlist.php?id=$id");
        
        }
?>

