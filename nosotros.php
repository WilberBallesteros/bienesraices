<?php
    require 'includes/app.php';
    incluirTemplate('header');
?>

    <main class="contenedor seccion">
        <h1>Conoce Sobre Nosotros</h1>

        <div class="contenido-nosotros">
            <div class="imagen">
                <picture>
                    <source srcset="build/img/nosotros.webp" type="image/webp">
                    <source srcset="build/img/nosotros.jpg" type="image/jpeg">
                    <img  loading="lazy" src="build/img/nosotros.jpg" alt="sobre nosotros">
                </picture>
            </div>

            <div class="texto-nosotros">
                <blockquote>
                    25 Años de Experiencia
                </blockquote>

                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur velit consequuntur voluptates veritatis fugiat, itaque possimus. Veritatis quaerat excepturi asperiores voluptas ut eum provident commodi iure aliquid nisi. Explicabo, fugit Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ex, rerum voluptate beatae earum voluptatem, inventore placeat reiciendis explicabo suscipit sapiente voluptatibus voluptatum porro, ullam aspernatur minus pariatur labore tempore cum! Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi delectus.</p>

                <p> at quo labore ab ratione. Quisquam, maxime? Lorem ipsum dolor sit amet consectetur adipisicing elit. Rerum tenetur similique a recusandae, quam eveniet ut iure deleniti doloribus consequatur accusamus. Eos nam temporibus optio praesentium exercitationem excepturi similique dolor!</p>
            </div>
        </div>
    </main>

    <section class="contenedor seccion">
        <h1>Más Sobre Nosotros</h1>

        <div class="iconos-nosotros">
            <div class="icono">
                <img src="build/img/icono1.svg" alt="icono seguridad" loading="lazy"> 
                <h3>Seguridad</h3>
                <p>Temporibus deleniti quo expedita veritatis nobis doloremque quae sapiente minima earum placeat quos, numquam quidem voluptatum perspiciatis voluptas dolorum aspernatur ut odio.</p>
            </div>

            <div class="icono">
                <img src="build/img/icono2.svg" alt="icono precio" loading="lazy"> 
                <h3>Precio</h3>
                <p>Temporibus deleniti quo expedita veritatis nobis doloremque quae sapiente minima earum placeat quos, numquam quidem voluptatum perspiciatis voluptas dolorum aspernatur ut odio.</p>
            </div>

            <div class="icono">
                <img src="build/img/icono3.svg" alt="icono Tiempo" loading="lazy"> 
                <h3>Tiempo</h3>
                <p>Temporibus deleniti quo expedita veritatis nobis doloremque quae sapiente minima earum placeat quos, numquam quidem voluptatum perspiciatis voluptas dolorum aspernatur ut odio.</p>
            </div>
        </div>
    </section>

<?php
    incluirTemplate('footer');
?>