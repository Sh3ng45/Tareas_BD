

<?php
$host = "localhost";
$bd = "prestigetravels";
$usuario = "root";
$contrasena = "";

try {
    $conexion = new PDO("mysql:host=$host;dbname=$bd",$usuario,$contrasena ); 
    if($conexion){} 
} catch (Exception $ex) {
    echo $ex->getMessage();  
}
?>