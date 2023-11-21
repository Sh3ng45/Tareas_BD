<?php include("template/head.php"); ?> 

<?php   
require 'prestigetravels.php'; 
if(!empty($_POST['usuario']) &&!empty($_POST['contrasena'])){     
  $registro = $conexion->prepare('SELECT * FROM usuario WHERE nombre= :usuario');     
  $registro -> bindParam(':usuario', $_POST['usuario'] );     
  $registro -> execute();      
  $resultado = $registro->fetch(PDO::FETCH_ASSOC);      
  $mensaje  ='';      
  if(count($resultado) > 0 && password_verify($_POST['contrasena'],$resultado['contrasena'])){         
    $_SESSION['user_id'] = $resultado['rut'];         
    header('Location: inicio.php');     
  }else{        
       $mensaje =  "Usuario no encontrado";     
  } 
} 
// // ?> 

    
  <div style="text-align:center">
  <h1> Incia sesión: </h1>
  <span> o <a href="registro.php"> crear cuenta</a></span>
  </div>
    <div class="container">
        <br/>
        <div class="row">
        <div class="col-md-4">
        </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">

                        <form method="POST">
                        <div class = "form-group">
                        <label>Usuario:</label>
                        <input type="text" class="form-control" name = "usuario" aria-describedby="emailHelp" placeholder="Ingrese usuario">
                    

                        </div>
                        <div class="form-group">
                        <label>Contraseña:</label>
                        <input type="password" class="form-control" name = "contrasena" placeholder="Ingrese contraseña">
                        </div>
                        </br>
                        <div class="card" >
                        <button type="submit" class="btn btn-primary">Ingresar a PrestigeTravels</button>
                        </div>

                        </form>
                    </div>
                </div>  
            </div>          
        </div>
    </div>
    
    <?php if(!empty($message)): ?>
      <p> <?= $message ?></p>
    <?php endif; ?>

  </body>
</html>