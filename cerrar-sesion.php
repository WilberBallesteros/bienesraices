<?php

session_start();

$_SESSION = []; //asignamos un arreglo vacio para destruir la sesion

header('Location: /bienesraices/');