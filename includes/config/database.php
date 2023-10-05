<?php

function conectarDB() : mysqli {
    $db = mysqli_connect('localhost:3307', 'root', '', 'bienesraices_crud'); //si dejo solo localhost se conecta a mysql q esta en el pc, en cambio 3307 es el de xammp

    if (!$db) {
        echo "Error no se pudo conectar";
        exit;
    }

    return $db;
}