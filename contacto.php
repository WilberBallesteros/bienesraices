<?php
    require 'includes/funciones.php';
    incluirTemplate('header');
?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Contacto</h1>

        <picture>
            <source srcset="build/img/destacada3.webp" type="img/webp">
            <source srcset="build/img/destacada3.jpg" type="img/jpeg">
            <img loading="lazy" src="build/img/destacada3.jpg" alt="imagen contacto">
        </picture>

        <h2>Llene el formulario de Contacto</h2>

        <form class="formulario">
            <fieldset>
                <legend>Información Personal</legend>
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" placeholder="Tu Nombre">

                <label for="email">E-mail:</label>
                <input type="email" id="email" placeholder="Tu Email">

                <label for="telefono">Teléfono:</label>
                <input type="tel" id="telefono" placeholder="Tu Teléfono">

                <label for="mensaje">Mensaje:</label>
                <textarea id="mensaje"></textarea>
            </fieldset>

            <fieldset>
                <legend>Información sobre Propiedad</legend>
                <label for="opciones">Vende o compra:</label>
                <select  id="opciones">
                    <option value="" disabled selected>-- Seleccione --</option>
                    <option value="Compra">Compra</option>
                    <option value="Vende">Vende</option>
                </select>

                <label for="presupuesto">Precio o Presupuesto:</label>
                <input type="number" id="presupuesto" min="0" placeholder="Tu Precio o presupuesto">

            </fieldset>

            <fieldset>
                <legend>Contacto</legend>
                <p>Como desea ser Contactado:</p>
                <div class="forma-contacto">
                    <label for="contactar-telefono">Teléfono</label>
                    <input name="contacto" type="radio" id="contactar-telefono" value="telefono">

                    <label for="contactar-email">E-mail</label>
                    <input name="contacto" type="radio" id="contactar-email" value="email">
                </div>

                <p>Si eligió teléfono, elija la fecha y la hora para ser contactado</p>
                <label for="fecha">Fecha:</label>
                <input type="date" id="fecha">

                <label for="hora">Hora:</label>
                <input type="time" id="hora" min="09:00" max="18:00">
            </fieldset>

            <input type="submit" value="Enviar" class="boton-verde">
        </form>
    </main>

<?php
    incluirTemplate('footer');
?>