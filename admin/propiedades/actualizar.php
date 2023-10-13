<?php

    //validar la URL por ID válido
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT); //valida q sea un int

    if (!$id) {
        header('Location: /bienesraices/admin');
    }

//base de datos
require '../../includes/config/database.php';
$db = conectarDB();

//obtener los datos de la propiedad
$consulta = "SELECT * FROM propiedades WHERE id = $id";
$resultado = mysqli_query($db, $consulta);
$propiedad = mysqli_fetch_assoc($resultado); //solo un resultado


//consultar para obtener los vendedores
$consulta = "SELECT * FROM vendedores";
$resultado = mysqli_query($db, $consulta); //base de datos y consulta q traemos

//Arreglo con mensaje de errores
$errores = [];

$titulo = $propiedad['titulo']; //le pasamos la info de la bd para prerellenar los inputs
$precio = $propiedad['precio'];
$descripcion = $propiedad['descripcion'];
$habitaciones = $propiedad['habitaciones'];
$wc = $propiedad['wc'];
$estacionamiento = $propiedad['estacionamiento'];
$vendedoresId = $propiedad['vendedores_id'];
$imagenPropiedad = $propiedad['imagen'];

//ejecutar el codigo despues de que el usuario envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {



    // echo "<pre>";
    // var_dump($_POST); //INFORMACION DE TIPO POST EN EL FORMULARIO
    // echo "</pre>";

        // echo "<pre>";
    // var_dump($_FILES); //CONTENIDO DE LOS ARCHIVOS
    // echo "</pre>";

    $titulo = mysqli_real_escape_string($db, $_POST['titulo']); //el q esta en verde es el q viene del name del formulario
    $precio = mysqli_real_escape_string($db, $_POST['precio']); //mysqli_real_escape_string es una funcion para q no hagan inyeccion sql, q sean numeros o strings segun sea necesario
    $descripcion = mysqli_real_escape_string($db, $_POST['descripcion']);
    $habitaciones = mysqli_real_escape_string($db, $_POST['habitaciones']);
    $wc = mysqli_real_escape_string($db, $_POST['wc']);
    $estacionamiento = mysqli_real_escape_string($db,  $_POST['estacionamiento']);
    $vendedoresId = mysqli_real_escape_string($db, $_POST['vendedor']);
    $creado = date('Y/m/d') ;

    //Asignar files hacia una variable
    $imagen = $_FILES['imagen'];

    //validar si escribieron si no manda al arreglo de errores
    if (!$titulo) {
        $errores[] = "Debes añadir un titulo"; //añade el error al final del arreglo
    }

    if (!$precio) {
        $errores[] = "El Precio es obligatorio";
    }

    if (strlen($descripcion) < 50) {
        $errores[] = "La Descripcion es obligatoria, y debe tener al menos 50 caracteres";
    }

    if (!$habitaciones) {
        $errores[] = "El numero de habitaciones es obligatorio";
    }

    if (!$wc) {
        $errores[] = "El numero de Baños es obligatorio";
    }

    if (!$estacionamiento) {
        $errores[] = "El numero de estacionamiento es obligatorio";
    }

    if (!$vendedoresId) {
        $errores[] = "Elige un vendedor";
    }

    //validar por tamaño (maximo una mega)
    $medida = 1000 * 1000;

    if ($imagen['size'] > $medida) {
        $errores[] = 'La imagen es muy pesada';
    }

    //revisar que el arreglo de errores esté vacio, si esta inserta en bd si no, no
    if (empty($errores)) {

         //crear una carpeta
         $carpetaImagenes = '../../imagenes/';

         if (!is_dir($carpetaImagenes)) { //si una carpeta existe o no
            mkdir($carpetaImagenes);
        }

        $nombreImagen = '';

        /**SUBIDA DE ARCHIVOS()IMAGENES**/

        if ($imagen['name']) {
            echo "si hay una imagen";

            //eliminar la imagen previa
            unlink($carpetaImagenes . $propiedad['imagen']);  //funcion para eliminar archvivos

            //generar un nombre unico
            $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg"; //hashear

            //subir la imagen 
            move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen );

        } else {
            $nombreImagen = $propiedad['imagen']; //si no cambia la imagen sera la imagen previa
        }
        

        //aCTUALIZAR en la base de datos
        
        $query = "UPDATE propiedades SET titulo = '$titulo', precio = $precio, imagen = '$nombreImagen', descripcion = '$descripcion', habitaciones = $habitaciones, wc = $wc, estacionamiento = $estacionamiento, vendedores_id = '$vendedoresId' WHERE id = $id ";

        //echo $query; //probar el query


        $resultado = mysqli_query($db, $query);

        if ($resultado) {
            //erdireccionar al usuario (como el formulario queda lleno evitar q lo envien cada rato x q creen q no paso )
            //echo "Insertado correctamente";
            header('Location: /bienesraices/admin?resultado=2'); //no debe haber nada de html previo para redireccionar(usar poco)
        }
    }
}



require '../../includes/funciones.php';
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
        <fieldset>
            <legend>Información General</legend>

            <label for="titulo">Titulo:</label>
            <input type="text" id="titulo" name="titulo" placeholder="Titulo Propiedad" value="<?php echo $titulo; ?>">

            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" placeholder="Precio Propiedad" value="<?php echo $precio; ?>">

            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">

            <img src="/bienesraices/imagenes/<?php echo $imagenPropiedad ?>" alt="imagen propiedad" class="imagen-small">

            <label for="descripcion">Descripcion:</label>
            <textarea id="descripcion" name="descripcion"><?php echo $descripcion; ?></textarea>
        </fieldset>

        <fieldset>
            <legend>Información Propiedad</legend>

            <label for="habitaciones">Habitaciones:</label>
            <input type="number" name="habitaciones" id="habitaciones" placeholder="Ej: 3" min="1" max="9" value="<?php echo $habitaciones; ?>">

            <label for="wc">Baños:</label>
            <input type="number" name="wc" id="wc" placeholder="Ej: 3" min="1" max="9" value="<?php echo $wc; ?>">

            <label for="estacionamiento">Estacionamiento:</label>
            <input type="number" name="estacionamiento" id="estacionamiento" placeholder="Ej: 3" min="1" max="9" value="<?php echo $estacionamiento; ?>">
        </fieldset>

        <fieldset>
            <legend>Vendedor</legend>

            <select name="vendedor">
                <option value="">-- Seleccione --</option>
                <?php while ($vendedor = mysqli_fetch_assoc($resultado)) { ?>

                    <option <?php echo $vendedoresId === $vendedor['id'] ? 'selected' : ''; ?> value="<?php echo $vendedor['id']; ?>"> <?php echo $vendedor['nombre'] . " " . $vendedor["apellido"]; ?> </option>

                <?php }; ?>
            </select>
        </fieldset>

        <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">
    </form>

</main>

<?php
incluirTemplate('footer');
?>