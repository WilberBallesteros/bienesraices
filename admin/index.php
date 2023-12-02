<?php

    require '../includes/app.php';
    //solo el admin pueda ingresar, autenticacion
    estaAutenticado();

    //importar clases
    use App\Propiedad;
    use App\Vendedor;


    //implementar un metodo para obtener todas las propiedades usando ACTIVE RECORD
    $propiedades = Propiedad::all();
    $vendedores = Vendedor::all();

    //Muestra mensaje condicional
    $resultado = $_GET['resultado'] ?? null; //si no existe resultado le pone null, http://localhost/bienesraices/admin/   en esta ruta no sale ningun error por q no encuentra resultado

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        //validar id
        $id = $_POST['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if ($id) {

            $tipo = $_POST['tipo'];

            if (validarTipoContenido($tipo)) {
                //Compara lo q vamos a eliminar
                if ($tipo === 'vendedor') {
                    //obtener los datos del vendedor
                    $vendedor = Vendedor::find($id);
                    $vendedor->eliminar();
                    
                } else if ($tipo === 'propiedad') {
                    //obtener los datos de la propiedad
                    $propiedad = Propiedad::find($id);
                    $propiedad->eliminar();
                }
            } 
        }
    }

    //incluye un template
    incluirTemplate('header');
?>

    <main class="contenedor seccion">
        <h1>Administrador de Bienes Raices</h1>

    <?php
        //codigo 1, 2 o 3 q esta en funciones.php
        $mensaje = mostrarNotificacion( intval($resultado) );
        if ($mensaje) { ?>
            <p class="alerta exito"> <?php echo s($mensaje) ?> </p>
        <?php } ?>

    ?>

        <a href="/bienesraices/admin/propiedades/crear.php" class="boton boton-verde">Nueva Propiedad</a>
        <a href="/bienesraices/admin/vendedores/crear.php" class="boton boton-amarillo">Nuevo Vendedor</a>

        <h2>Popiedades</h2>
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
                            <input type="hidden" name="tipo" value="propiedad">
                            <input type="submit" class="boton-rojo-block" value="Eliminar" >
                        </form>
                        
                        <a class="boton-amarillo-block" href="/bienesraices/admin/propiedades/actualizar.php?id=<?php echo $propiedad->id; ?>">Actualizar</a>
                    </td>
                </tr>

                <?php endforeach ?>
            </tbody>
        </table>

        <h2>Vendedores</h2>

        <table class="propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Telefono</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody> <!--4. Mostrar los resultados-->
            <?php foreach( $vendedores as $vendedor ) : ?>
                <tr>
                    <td> <?php echo $vendedor->id; ?> </td>
                    <td> <?php echo $vendedor->nombre . " " . $vendedor->apellido; ?> </td>
                    <td> <?php echo $vendedor->telefono; ?> </td>
                    <td>
                        <form method="POST"   class="W-100">

                        <input type="hidden" name="id" value="<?php echo $vendedor->id;  ?>">
                        <input type="hidden" name="tipo" value="vendedor">
                        <input type="submit" class="boton-rojo-block" value="Eliminar" >
                        </form>
                        
                        <a class="boton-amarillo-block" 
                        href="/bienesraices/admin/vendedores/actualizar.php?id=<?php echo $vendedor->id; ?>">Actualizar</a>
                    </td>
                </tr>

                <?php endforeach ?>
            </tbody>
        </table>
    </main>

<?php
    incluirTemplate('footer');
?>