<?php include("template/head.php"); 
    require 'prestigetravels.php';
    include("bdd.php");

$accion = (isset($_POST["accion"]))?$_POST["accion"]:"";
if(isset($_GET['id'])){
    $id = mysqli_real_escape_string($conex,$_GET['id']);

    $select = "SELECT nombre, email, fecha_nacimiento FROM usuario WHERE rut='$id'";
    $resultado = mysqli_query($conex,$select);
    
    $row = mysqli_fetch_array($resultado);
}
?>
<div class="jumbotron">
    <h1 class="display-3"><?php ?></h1>
    <h1>Nombre: 
        <?php if(isset($_POST['nombre']) AND $_POST['nombre'] != null) {
            $nombre = $_POST['nombre'];
            $query1 = "UPDATE `usuario` SET `nombre`='$nombre' WHERE rut='$id'";
            $resultado1 = mysqli_query($conex, $query1);
        } else {
            $nombre = $row['nombre'];
        }
        ?>
        <span id="nombre"><?php echo $nombre; ?></span>
        <button class="btn btn-primary btn-sm" onclick="editarCampo('nombre')">Editar</button>
    </h1>
    <h1>Correo: 
        <?php if(isset($_POST['correo']) AND $_POST['correo'] != null) {
            $correo = $_POST['correo'];
            $query1 = "UPDATE `usuario` SET `email`='$correo' WHERE rut='$id'";
            $resultado1 = mysqli_query($conex, $query1);
        } else {
            $correo = $row['email'];
        }
        ?>
        <span id="correo"><?php echo $correo; ?></span>
        <button class="btn btn-primary btn-sm" onclick="editarCampo('correo')">Editar</button>
    </h1>
    <h1>Fecha de Nacimiento: 
        <?php if(isset($_POST['fecha']) AND $_POST['fecha'] != null) {
            $fecha = $_POST['fecha'];
            $query1 = "UPDATE `usuario` SET `fecha_nacimiento`='$fecha' WHERE rut='$id'";
            $resultado1 = mysqli_query($conex, $query1);
        } else {
            $fecha = $row['fecha_nacimiento'];
        }
        ?>
        <span id="fecha"><?php echo $fecha; ?></span>
        <button class="btn btn-primary btn-sm" onclick="editarCampo('fecha')">Editar</button>
    </h1>
    <hr class="my-2">
    <p class="lead">
        <a class="btn btn-primary btn-lg" href="eliminar_cuenta.php?id=<?php echo $id; ?>" role="button">Eliminar cuenta</a>
    </p>
</div>

<script>
    function editarCampo(campo) {
        var valor = document.getElementById(campo).innerHTML;
        var nuevoValor = prompt("Ingrese el nuevo valor para " + campo + ":", valor);
        if (nuevoValor !== null) {
            document.getElementById(campo).innerHTML = nuevoValor;
            document.getElementById('form_' + campo).value = nuevoValor;
            document.getElementById('form').submit();
        }
    }
</script>

<form id="form" method="POST" style="display: none;">
    <input type="hidden" id="form_nombre" name="nombre" >
    <input type="hidden" id="form_correo" name="correo" >
    <input type="hidden" id="form_fecha" name="fecha" >
</form>
