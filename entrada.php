<?php
    require 'includes/app.php';
    incluirTemplate('header');
?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Guía para la decoración de tu hogar</h1>
        <picture>
            <source srcset="build/img/destacada2.webp" type="image/webp">
            <source srcset="build/img/destacada2.jpg" type="image/jpeg">
            <img loading="lazy" src="build/img/destacada2.jpg" alt="imagen de la propiedad">
        </picture>

        <p class="informacion-meta">Escrito el: <span>20/10/08</span> por: <span>Admin</span></p>

        <div class="resumen-propiedad">
        
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam quam illo ducimus, enim sunt placeat sequi, est mollitia quaerat voluptatem quia sapiente distinctio? Veniam harum nisi ducimus neque, inventore ratione! Lorem ipsum dolor sit, amet consectetur adipisicing elit. Possimus provident in libero voluptatem nihil cumque culpa tempore earum, magni id atque a et. Sapiente dolore impedit excepturi amet tempora hic. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aliquid ipsam voluptatum vero saepe aspernatur error, recusandae doloribus et quod magni architecto necessitatibus temporibus dolores est. Error quia excepturi recusandae nulla!</p>

            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam quam illo ducimus, enim sunt placeat sequi, est mollitia quaerat voluptatem quia sapiente distinctio? Veniam harum nisi ducimus neque, inventore ratione! Lorem ipsum dolor sit, amet consectetur adipisicing elit. Possimus provident in libero voluptatem nihil cumque culpa tempore earum</p>
        </div>
    </main>

<?php
    incluirTemplate('footer');
?>