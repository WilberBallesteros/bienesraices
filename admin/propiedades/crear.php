<?php

    require '../../includes/app.php';

    use App\Propiedad;
    use Intervention\Image\ImageManagerStatic as Image;

    //solo el admin pueda ingresar, autenticacion
    estaAutenticado();

    //base de datos
    $db = conectarDB();

    $propiedad = new Propiedad; //para tener el objeto $propiedad totalmente vacio

    //consultar para obtener los vendedores

    $consulta = "SELECT * FROM vendedores";
    $resultado = mysqli_query($db, $consulta); //base de datos y consulta q traemos

    //Arreglo con mensaje de errores
    $errores = Propiedad::getErrores();
    
    //ejecutar el codigo despues de que el usuario envía el formulario
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        /** Crea una nueva instancia **/
        $propiedad = new Propiedad($_POST['propiedad']); //los atributos del formulario estan en un arreglo propiedad

        //debuguear($_FILES['propiedad']);

        /**SUBIDA DE ARCHIVOS()IMAGENES**/
        
        //generar un nombre unico
        $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg"; //hashear

        //setear la imagen
        //realiza un resize a la imagen con intervention (imagen en memoria)
        if ($_FILES['propiedad']['tmp_name']['imagen']) {
            $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600); //00 ancho, 600 alto
            $propiedad->setImage($nombreImagen);
        }

        //validar imagen
        $errores = $propiedad->validar();

    if (empty($errores)) {

        //crear la carpeta para subir imagenes
        if (!is_dir(CARPETA_IMAGENES)) {
            mkdir(CARPETA_IMAGENES);
        }

        //guarda la imagen en el servidor
        $image->save(CARPETA_IMAGENES . $nombreImagen);

        //guarda en la base de datos
        $resultado = $propiedad->guardar();

        //mensaje de exito o error
        if ($resultado) {
            //erdireccionar al usuario (como el formulario queda lleno evitar q lo envien cada rato x q creen q no paso )
            //echo "Insertado correctamente";
            header('Location: /bienesraices/admin?resultado=1'); //no debe haber nada de html previo para redireccionar(usar poco)
        }
    }
}


incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Crear</h1>

    <a href="/bienesraices/admin" class="boton boton-verde">Volver</a>

    <?php foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach ?>


    <form class="formulario" method="post" action="/bienesraices/admin/propiedades/crear.php" enctype="multipart/form-data">
        <?php include '../../includes/templates/formulario_propiedades.php' ?>
        <input type="submit" value="crear Propiedad" class="boton boton-verde">
    </form>

</main>

<?php
incluirTemplate('footer');
?>