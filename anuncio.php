<?php
    require 'includes/funciones.php';
    incluirTemplate('header');
?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Casa en Venta frente al bosque</h1>
        <picture>
            <source srcset="build/img/destacada.webp" type="image/webp">
            <source srcset="build/img/destacada.jpg" type="image/jpeg">
            <img loading="lazy" src="build/img/destacada.jpg" alt="imagen de la propiedad">
        </picture>

        <div class="resumen-propiedad">
            <p class="precio">$300.000.000</p>
            <ul class="iconos-caracteristicas">
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
                    <p>3</p>
                </li>
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                    <p>3</p>
                </li>
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono habitaciones">
                    <p>4</p>
                </li>
            </ul>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam quam illo ducimus, enim sunt placeat sequi, est mollitia quaerat voluptatem quia sapiente distinctio? Veniam harum nisi ducimus neque, inventore ratione! Lorem ipsum dolor sit, amet consectetur adipisicing elit. Possimus provident in libero voluptatem nihil cumque culpa tempore earum, magni id atque a et. Sapiente dolore impedit excepturi amet tempora hic. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aliquid ipsam voluptatum vero saepe aspernatur error, recusandae doloribus et quod magni architecto necessitatibus temporibus dolores est. Error quia excepturi recusandae nulla!</p>

            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam quam illo ducimus, enim sunt placeat sequi, est mollitia quaerat voluptatem quia sapiente distinctio? Veniam harum nisi ducimus neque, inventore ratione! Lorem ipsum dolor sit, amet consectetur adipisicing elit. Possimus provident in libero voluptatem nihil cumque culpa tempore earum</p>
        </div>
    </main>

<?php
    incluirTemplate('footer');
?>