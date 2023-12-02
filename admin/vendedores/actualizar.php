<?php

    require '../../includes/app.php';
    use App\Vendedor;
    estaAutenticado();

    //validar q sea un ID valido
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if (!$id) {
        header('Location: /bienesraices/admin');
    }

    //obtener el arreglo del vendedor desde la BD
    $vendedor = Vendedor::find($id);


      //Arreglo con mensaje de errores
    $errores = Vendedor::getErrores();

     //ejecutar el codigo despues de que el usuario envía el formulario
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        //asignar los valores
        $args = $_POST['vendedor'];
        //sincronizar objeto en memoria con lo q el usuario escribio
        $vendedor->sincronizar($args);

        //validacion por q el usuario borre todo y despues se le olvide escribir algun ccampo
        $errores = $vendedor->validar();

        if (empty($errores)) {
            $vendedor->guardar();
        }

    }

    incluirTemplate('header');

    ?>

<main class="contenedor seccion">
    <h1>Actualizar Vendedor(a)</h1>

    <a href="/bienesraices/admin" class="boton boton-verde">Volver</a>

    <?php foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach ?>


    <form class="formulario" method="POST" >
        <?php include '../../includes/templates/formulario_vendedores.php' ?>
        <input type="submit" value="Guardar Cambios" class="boton boton-verde">
    </form>

</main>

<?php
incluirTemplate('footer');
?>