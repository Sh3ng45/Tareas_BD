<?php include("template/head.php"); 
    require 'bdd.php';?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Reseñas</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
        <style>
            /* Estilos adicionales personalizados */
            /* Agrega tus estilos personalizados aquí */
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Reseñas</h1>
            
            <?php
            // Aquí debes escribir el código PHP para conectar a la base de datos y recuperar las reseñas existentes
            // Asumiremos que ya tienes la conexión establecida y los datos almacenados en un arreglo llamado $reseñas
            
            // Ejemplo de datos de reseñas (puedes reemplazar esto con tu código para recuperar los datos de la base de datos)
            $reseñas = array(
                array(
                    'id' => 1,
                    'usuario' => 'Usuario1',
                    'calificacion' => 4,
                    'detalle1' => 'Detalle 1',
                    'detalle2' => 'Detalle 2',
                    'detalle3' => 'Detalle 3',
                    'detalle4' => 'Detalle 4',
                    'comentario' => 'Esta es una reseña muy buena.',
                ),
                array(
                    'id' => 2,
                    'usuario' => 'Usuario2',
                    'calificacion' => 5,
                    'detalle1' => 'Detalle 1',
                    'detalle2' => 'Detalle 2',
                    'detalle3' => 'Detalle 3',
                    'detalle4' => 'Detalle 4',
                    'comentario' => '¡Excelente! Sin duda, recomiendo este producto.',
                ),
                // ... más reseñas ...
            );
            
            // Mostrar las reseñas existentes
            if (!empty($reseñas)) {
                foreach ($reseñas as $res) {
                    $id = $res['id'];
                    $usuario = $res['usuario'];
                    $calificacion = $res['calificacion'];
                    $detalle1 = $res['detalle1'];
                    $detalle2 = $res['detalle2'];
                    $detalle3 = $res['detalle3'];
                    $detalle4 = $res['detalle4'];
                    $comentario = $res['comentario'];
                    
                    echo '
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">'.$usuario.'</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Calificación: '.$calificacion.'/5</h6>
                            <p class="card-text">Detalle 1: '.$detalle1.'</p>
                            <p class="card-text">Detalle 2: '.$detalle2.'</p>
                            <p class="card-text">Detalle 3: '.$detalle3.'</p>
                            <p class="card-text">Detalle 4: '.$detalle4.'</p>
                            <p class="card-text">'.$comentario.'</p>';
                            
                            // Agregar botones de edición y eliminación solo para el usuario que hizo la reseña
                            // Asume que tienes el ID del usuario actual en una variable llamada $idUsuarioActual
                            // Si el usuario actual coincide con el usuario que hizo la reseña, se muestran los botones
                            if ($idUsuarioActual === $id) {
                                echo '
                                <a href="#" class="btn btn-primary">Editar</a>
                                <a href="#" class="btn btn-danger">Eliminar</a>';
                            }
                            
                    echo '</div>
                    </div>';
                }
            } else {
                echo '<p>No hay reseñas disponibles.</p>';
            }
            ?>
            
            <!-- Formulario para agregar una nueva reseña -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Agregar Reseña</h5>
                    <form action="#" method="POST">
                        <!-- Agrega los campos necesarios para capturar los detalles y la calificación de la reseña -->
                        <div class="mb-3">
                            <label for="calificacion" class="form-label">Calificación:</label>
                            <input type="number" class="form-control" id="calificacion" name="calificacion" min="1" max="5" required>
                        </div>
                        <!-- Agrega los campos para los detalles -->
                        <div class="mb-3">
                            <label for="detalle1" class="form-label">Detalle 1:</label>
                            <input type="text" class="form-control" id="detalle1" name="detalle1" required>
                        </div>
                        <!-- Agrega los campos para los detalles 2, 3 y 4 -->
                        <!-- ... -->
                        <div class="mb-3">
                            <label for="comentario" class="form-label">Comentario:</label>
                            <textarea class="form-control" id="comentario" name="comentario" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </form>
                </div>
            </div>
        </div>
    
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
    