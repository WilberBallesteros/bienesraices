
<?php
//IMPORTANTE!! una vex llevemos el proyecto a produccion, cuando creemos nuestro primer usuario, este archivo
//hay q eliminarlo

//1.importar la conexion
require 'includes/config/database.php';
$db = conectarDB();

//2. crear un email y password
$email = "correo@correo.com";
$password = "123456";

//hashear password
$passwordHash = password_hash($password, PASSWORD_BCRYPT);

//3. query para crear el usuario
$query = " INSERT INTO usuarios (email, password) VALUES ('$email', '$passwordHash'); ";
//echo $query;

//4.agregarlo a la base de datos
mysqli_query($db, $query);

?>