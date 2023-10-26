<?php

    require '../includes/app.php';
    //solo el admin pueda ingresar, autenticacion
    estaAutenticado();

    use App\Propiedad;

    $db = conectarDB();

    //implementar un metodo para obtener todas las propiedades usando ACTIVE RECORD
    $propiedades = Propiedad::all();

    //Muestra mensaje condicional
    $resultado = $_GET['resultado'] ?? null; //si no existe resultado le pone null, http://localhost/bienesraices/admin/   en esta ruta no sale ningun error por q no encuentra resultado

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if ($id) {

            //eliminar el archivo
            $query = "SELECT imagen FROM propiedades WHERE id = $id";
            $resultado = mysqli_query($db, $query);
            $propiedad = mysqli_fetch_assoc($resultado);
            unlink('../imagenes/' . $propiedad['imagen']);

            //eliminar la propiedad
            $query = "DELETE FROM propiedades WHERE id = $id";
            $resultado = mysqli_query($db, $query);

            if ($resultado) {
                header('Location: /bienesraices/admin?resultado=3');
            }
        }
    }

    //incluye un template
    incluirTemplate('header');
?>

    <main class="contenedor seccion">
        <h1>Administrador de Bienes Raices</h1>

        <?php  if( intval($resultado ) === 1):   ?> 
            <p class="alerta exito">Anuncio creado correctamente</p>
            <?php elseif(intval($resultado ) === 2) : ?>
                <p class="alerta exito">Anuncio Actualizado correctamente</p>
            <?php elseif(intval($resultado ) === 3) : ?>
            <p class="alerta exito">Anuncio Eliminado correctamente</p>
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

            <tbody> <!--4. Mostrar los resultados-->
            <?php foreach( $propiedades as $propiedad ) : ?>
                <tr>
                    <td> <?php echo $propiedad->id; ?> </td>
                    <td> <?php echo $propiedad->titulo; ?> </td>
                    <td> <img class="imagen-tabla" src="../imagenes/<?php echo $propiedad->imagen; ?>" alt="imagen"> </td>
                    <td> <?php echo $propiedad->precio; ?> </td>
                    <td>
                        <form method="POST"   class="W-100">

                        <input type="hidden" name="id" value="<?php echo $propiedad->id;  ?>">

                        <input type="submit" class="boton-rojo-block" value="Eliminar" >
                        </form>
                        
                        <a class="boton-amarillo-block" href="/bienesraices/admin/propiedades/actualizar.php?id=<?php echo $propiedad->id; ?>">Actualizar</a>
                    </td>
                </tr>

                <?php endforeach ?>
            </tbody>
        </table>
    </main>

<?php

    //5. cerrar la conexion
    mysqli_close($db);

    incluirTemplate('footer');
?>