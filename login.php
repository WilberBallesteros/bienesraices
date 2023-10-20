<?php

    require 'includes/app.php';
    $db = conectarDB();

    //Autenticar el usuario

    $errores = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
        $email =  mysqli_real_escape_string($db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))  ; //Valida el emai
        $password =  mysqli_real_escape_string($db, $_POST['password']); //real_scape q no pongan caract. especiales

        if (!$email) {
            $errores[] = "El email es obligatorio o no es válido";
        }

        if (!$password) {
            $errores[] = "El password es obligatorio";
        }

        if (empty($errores)) {
            //revisar si el usuario existe
            $query = "SELECT * FROM usuarios WHERE email = '$email' ";
            $resultado = mysqli_query($db, $query);

            

            if ($resultado->num_rows) {  //si hay resultados en la consulta a la bd
                //revisar si el password es correcto
                $usuario = mysqli_fetch_assoc($resultado);

                //verificar si el password es correcto o no
                $auth = password_verify($password, $usuario['password']); //password q el susuario escribio, password de la base de datos y la funcion nos retorna true o false 

                if ($auth) {
                    //el usuario está autenticado
                    session_start();

                    //llenar el arreglo de la sesion
                    $_SESSION['usuario'] = $usuario['email'];
                    $_SESSION['login'] = true;

                    header('Location: /bienesraices/admin');

                } else {
                    //el password es incorrecto
                    $errores[] = "El password es incorrecto";
                }

            } else {
                $errores[] = "El Usuario no existe";
            }
        }
    }

    //incluye el header
    incluirTemplate('header');
?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Iniciar Sesión</h1>

        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>

        <form method="POST" class="formulario" novalidate>

        <legend>Email y Password</legend>
            <fieldset>
                
                <label for="email">E-mail:</label>
                <input name="email" type="email" id="email" placeholder="Tu Email" >

                <label for="password">Password:</label>
                <input name="password" type="password" id="password" placeholder="Tu Contraseña" >

            </fieldset>

            <input type="submit" value="Iniciar Sesión" class="boton boton-verde">

        </form>
    </main>

<?php
    incluirTemplate('footer');
?>