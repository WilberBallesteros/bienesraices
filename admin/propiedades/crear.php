<?php
//base de datos
require '../../includes/config/database.php';

$db = conectarDB();

//consultar para obtener los vendedores

$consulta = "SELECT * FROM vendedores";
$resultado = mysqli_query($db, $consulta); //base de datos y consulta q traemos

//Arreglo con mensaje de errores
$errores = [];

$titulo = '';
$precio = '';
$descripcion = '';
$habitaciones = '';
$wc = '';
$estacionamiento = '';
$vendedoresId = '';

//ejecutar el codigo despues de que el usuario envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {



    // echo "<pre>";
    // var_dump($_POST);
    // echo "</pre>";

    $titulo = mysqli_real_escape_string($db, $_POST['titulo']); //el q esta en verde es el q viene del name del formulario
    $precio = mysqli_real_escape_string($db, $_POST['precio']); //mysqli_real_escape_string es una funcion para q no hagan inyeccion sql, q sean numeros o strings segun sea necesario
    $descripcion = mysqli_real_escape_string($db, $_POST['descripcion']);
    $habitaciones = mysqli_real_escape_string($db, $_POST['habitaciones']);
    $wc = mysqli_real_escape_string($db, $_POST['wc']);
    $estacionamiento = mysqli_real_escape_string($db,  $_POST['estacionamiento']);
    $vendedoresId = mysqli_real_escape_string($db, $_POST['vendedor']);
    $creado = date('Y/m/d') ;

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


    //revisar que el arreglo de errores esté vacio, si esta inserta en bd si no, no
    if (empty($errores)) {
        //Insertar en la base de datos

        $query = " INSERT INTO propiedades (titulo, precio, descripcion, habitaciones, wc, estacionamiento, creado,
            vendedores_id) VALUES ( '$titulo', '$precio', '$descripcion', '$habitaciones', '$wc', '$estacionamiento', '$creado', '$vendedoresId' ) ";

        //echo $query; //probar el query

        $resultado = mysqli_query($db, $query);

        if ($resultado) {
            //erdireccionar al usuario (como el formulario queda lleno evitar q lo envien cada rato x q creen q no paso )
            //echo "Insertado correctamente";
            header('Location: /bienesraices/admin'); //no debe haber nada de html previo para redireccionar(usar poco)
        }
    }
}



require '../../includes/funciones.php';
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


    <form class="formulario" method="post" action="/bienesraices/admin/propiedades/crear.php">
        <fieldset>
            <legend>Información General</legend>

            <label for="titulo">Titulo:</label>
            <input type="text" id="titulo" name="titulo" placeholder="Titulo Propiedad" value="<?php echo $titulo; ?>">

            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" placeholder="Precio Propiedad" value="<?php echo $precio; ?>">

            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" accept="image/jpeg, image/png">

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

        <input type="submit" value="crear Propiedad" class="boton boton-verde">
    </form>

</main>

<?php
incluirTemplate('footer');
?>