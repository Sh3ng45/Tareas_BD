<?php
    include("bdd.php");
    // Verificar si se ha enviado la ID mediante POST
    if(isset($_GET['id'])){
        $id = $_GET['id'];

        $delete = "DELETE FROM `usuario` WHERE rut='$id'";
        $resultado = mysqli_query($conex, $delete);


        session_start();

        session_unset();
      
        session_destroy();
        header('Location: inicio.php');
    }
?>
