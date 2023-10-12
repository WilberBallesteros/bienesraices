<?php
    $resultado = $_GET['resultado'] ?? null; //si no existe resultado le pone null, http://localhost/bienesraices/admin/   en esta ruta no sale ningun error por q no encuentra resultado
    require '../includes/funciones.php';
    incluirTemplate('header');
?>

    <main class="contenedor seccion">
        <h1>Administrador de Bienes Raices</h1>

        <?php  if( intval($resultado ) === 1):   ?> 
            <p class="alerta exito">Anuncio creado correctamente</p>
        <?php endif; ?>

        <a href="/bienesraices/admin/propiedades/crear.php" class="boton boton-verde">Nueva Propiedad</a>

        <table class="propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titulo</th>
                    <th>Imagen</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>1</td>
                    <td>Casa en la playa</td>
                    <td> <img class="imagen-tabla" src="../imagenes/22c32dde5a03315123034711c5a17431.jpg" alt="imagen"> </td>
                    <td>120000</td>
                    <td>
                        <a class="boton-rojo-block" href="#">Eliminar</a>
                        <a class="boton-amarillo-block" href="#">Actualizar</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </main>

<?php
    incluirTemplate('footer');
?>