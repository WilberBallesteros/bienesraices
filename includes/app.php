<?php

//va a llamar funciones y clases

require 'funciones.php';
require 'config/database.php';
require __DIR__ . '/../vendor/autoload.php';

//conectarnos a la base de datos
$db = conectarDB();

use App\ActiveRecord;

//lo hago en este archivo x q aqui tenemos la configuracion a la base de datos
ActiveRecord::setDB($db); //todos los elementos q se instancien van a tener la referencia la la base de datos



