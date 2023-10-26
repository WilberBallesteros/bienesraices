<?php

define('TEMPLATES_URL', __DIR__ . '/templates'); /* entramos a esta carpeta*/
define('FUNCIONES_URL', __DIR__ . 'funciones.php');
define('CARPETA_IMAGENES', __DIR__ . '/../imagenes/');


function incluirTemplate(string $nombre, bool $inicio = false ) {
    include TEMPLATES_URL . "/{$nombre}.php";
}

function estaAutenticado() : bool {
    session_start();

    if (!$_SESSION['login']) {
        header('Location: /bienesraices/');
    } 
    
    return false;
}

function debuguear($variable) {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

//escapa / sanitizar el HTML hacerlo siempre en todos los proyectos para evitar inyeccion sql
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}