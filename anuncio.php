<?php

    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if (!$id) {
        header('Location: /bienesraices/');
    }

    //1.importar la conexion
    //require 'includes/config/database.php'; //ESTE ES LO MISMO QUE EL DE DIR  ya no se necesita por app composer
    require 'includes/app.php';
    $db = conectarDB();

    //2.consultar la bd
    $query = "SELECT * FROM propiedades WHERE id = $id";

    //3. obtener resultado
    $resultado = mysqli_query($db, $query);


    //POO para acceder a una propiedad se hace con sintaxis de flecha
    if (!$resultado->num_rows) {
        header('Location: /bienesraices/');
    }


    $propiedad = mysqli_fetch_assoc($resultado) ; //como solo es un resultado q no se itera se usa mysqli_fetch_assoc


    incluirTemplate('header');
?>

    <main class="contenedor seccion contenido-centrado">
        <h1><?php echo $propiedad['titulo']; ?></h1>
        
            <img loading="lazy" src="/bienesraices/imagenes/<?php echo $propiedad['imagen']; ?>" alt="imagen de la propiedad">

        <div class="resumen-propiedad">
            <p class="precio">$<?php echo $propiedad['precio']; ?></p>
            <ul class="iconos-caracteristicas">
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
                    <p><?php echo $propiedad['wc']; ?></p>
                </li>
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                    <p><?php echo $propiedad['estacionamiento']; ?></p>
                </li>
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono habitaciones">
                    <p><?php echo $propiedad['habitaciones']; ?></p>
                </li>
            </ul>
            <p><?php echo $propiedad['descripcion']; ?></p>

            
        </div>
    </main>

<?php
    //cerrar la conexion
    mysqli_close($db);
    incluirTemplate('footer');
?>