<?php

    require '../../includes/app.php';

    use App\Vendedor;

     //solo el admin pueda ingresar, autenticacion
     estaAutenticado();

     $vendedor = new Vendedor; //nos crea un nuevo objeto sin el parentesis Vendedor()

      //Arreglo con mensaje de errores
    $errores = Vendedor::getErrores();

     //ejecutar el codigo despues de que el usuario envía el formulario
     if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        //Crear una nueva instancia
        $vendedor = new Vendedor($_POST['vendedor']);

        //validar q no haya campos vacios
        $errores = $vendedor->validar();

        //no hay errores entonss hay q guardarlo
        if (empty($errores)) {  //empty funcion q mira si un arreglo esta vacio
            //guarda en la base de datos
            $vendedor->guardar();
        }

    }

    incluirTemplate('header');

    ?>

<main class="contenedor seccion">
    <h1>Registrar Vendedor(a)</h1>

    <a href="/bienesraices/admin" class="boton boton-verde">Volver</a>

    <?php foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach ?>


    <form class="formulario" method="post" action="/bienesraices/admin/vendedores/crear.php">
        <?php include '../../includes/templates/formulario_vendedores.php' ?>
        <input type="submit" value="Registrar Vendedor(a)" class="boton boton-verde">
    </form>

</main>

<?php
incluirTemplate('footer');
?>