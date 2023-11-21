<?php 
require 'prestigetravels.php';

$accion = (isset($_POST["boton"])) ? $_POST["boton"] : "";
$mensaje = '';

switch ($accion) {
    case "Send":
        if (!empty($_POST['rut']) && !empty($_POST['nombre']) && !empty($_POST['contrasena']) && !empty($_POST['fecha_nacimiento']) && !empty($_POST['email'])) {
            $sql =  "INSERT INTO `usuario` (`rut`, `nombre`, `contrasena`, `fecha_nacimiento`, `email`) VALUES (:rut, :nombre, :contrasena, :fecha_nacimiento, :email);";
            $sentencia = $conexion->prepare($sql);
            $sentencia->bindParam(':rut', $_POST['rut']);
            $sentencia->bindParam(':nombre', $_POST['nombre']);
            $contra = password_hash($_POST['contrasena'], PASSWORD_BCRYPT);
            $sentencia->bindParam(':contrasena', $contra);
            $sentencia->bindParam(':fecha_nacimiento', $_POST['fecha_nacimiento']);
            $sentencia->bindParam(':email', $_POST['email']);

            $fecha = new DateTime();
            if ($sentencia->execute()) {
                $mensaje = 'Usuario creado correctamente';
            } else {
                $mensaje = 'Ha habido un error al crear el usuario';
            }
        }
        break;
}   
?>

<?php include("template/head.php"); ?> 
    
<div style="text-align:center">
    <h1>Crear cuenta:</h1>
    <span>o <a href="login.php">inicia sesión</a></span>
</div>

<div class="container">
    <br/>
    <div class="row">
        <div class="col-md-4">
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>RUT:</label>
                            <input type="text" class="form-control" name="rut" placeholder="Ingrese RUT">
                        </div>
                        <div class="form-group">
                            <label>Nombre:</label>
                            <input type="text" class="form-control" name="nombre" placeholder="Ingrese nombre">
                        </div>
                        <div class="form-group">
                            <label>Contraseña:</label>
                            <input type="password" class="form-control" name="contrasena" placeholder="Ingrese contraseña">
                        </div>
                        <div class="form-group">
                            <label>Fecha de Nacimiento:</label>
                            <input type="date" class="form-control" name="fecha_nacimiento" placeholder="Ingrese fecha de nacimiento">
                        </div>
                        <div class="form-group">
                            <label>Email:</label>
                            <input type="email" class="form-control" name="email" placeholder="Ingrese email">
                        </div>
                        <br/>
                        <div class="card">
                            <button type="submit" name="boton" class="btn btn-primary" value="Send">Crear usuario</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div style="text-align:center">
    <?php if (!empty($mensaje)): ?>
        <p><?= $mensaje ?></p>
    <?php endif ?>
</div>

</body>
</html>

