<?php

use App\Propiedad;
use Intervention\Image\ImageManagerStatic as Image;

    require '../../includes/app.php';
    //solo el admin pueda ingresar, autenticacion
    estaAutenticado();
   
    //validar la URL por ID válido
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT); //valida q sea un int

    if (!$id) {
        header('Location: /bienesraices/admin');
    }

//obtener los datos de la propiedad
$propiedad = Propiedad::find($id);

//consultar para obtener los vendedores
$consulta = "SELECT * FROM vendedores";
$resultado = mysqli_query($db, $consulta); //base de datos y consulta q traemos

//Arreglo con mensaje de errores
$errores = Propiedad::getErrores();

//ejecutar el codigo despues de que el usuario envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //asignar los atributos

    $args = $_POST['propiedad']; //todos los campos en el formulario los pusimos dentro de un array q se llama propiedad 
    
    $propiedad->sincronizar($args);

    //validacion
    $errores = $propiedad->validar();

    //subida de archivos

    //generar un nombre unico
        $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg"; //hashear

    if ($_FILES['propiedad']['tmp_name']['imagen']) {
        $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600); //00 ancho, 600 alto
        $propiedad->setImage($nombreImagen);
    }
    
    if (empty($errores)) {
        //almacenar la imagen en disco duro

        if ($_FILES['propiedad']['tmp_name']['imagen']) {
            $image->save(CARPETA_IMAGENES . $nombreImagen);
        }
        
        $propiedad->guardar();
    }
}

incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Actualizar Propiedad</h1>

    <a href="/bienesraices/admin" class="boton boton-verde">Volver</a>

    <?php foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach ?>


    <form class="formulario" method="post" enctype="multipart/form-data">
        
        <?php include '../../includes/templates/formulario_propiedades.php' ?>

        <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">
    </form>

</main>

<?php
incluirTemplate('footer');
?>