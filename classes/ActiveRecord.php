<?php

namespace App;

class ActiveRecord {
     //base de datos
    protected  static $db; //static por q no requerimis diferentes instancias o conexiones
    protected static $columnasDB = []; //al heredarlo lo reescribimos, sea en Vendedor o Propiedad

    protected static $tabla = '';

    // errores o validaciones
    protected static $errores = [];


   

     //definir la conexion a la BD
    public static function setDB($database) {
        self::$db = $database;  //self hace referencia a los atributos estaticos de la misma clase
    }

    

    public function guardar() {
        if (!is_null($this->id)) {
            //actualizar
            $this->actualizar();
        } else {
            //creando un nuevo registro
            $this->crear();
        }
    }

    public function crear() {

        //sanitizar la entrada de los datos
        $atributos = $this->sanitizarAtributos();

        //Insertar en la base de datos

        //codigo profe
        // $query = " INSERT INTO propiedades ( ";
        // $query .= join(', ', array_keys($atributos)); //crear un nuevo string a partir de un arreglo
        // $query .= " ) VALUES (' "; 
        // $query .= join("', '", array_values($atributos)); //valores del arreglo
        // $query .= " ') ";

        //codigo estudiante
        $columnas = join(', ',array_keys($atributos));
        $fila = join("', '",array_values($atributos));
        $query = "INSERT INTO " . static::$tabla . "($columnas) VALUES ('$fila')";
        $resultado = self::$db->query($query);
        //mensaje de exito o error
        if ($resultado) {
            //erdireccionar al usuario (como el formulario queda lleno evitar q lo envien cada rato x q creen q no paso )
            //echo "Insertado correctamente";
            header('Location: /bienesraices/admin?resultado=1'); //no debe haber nada de html previo para redireccionar(usar poco)
        }
    }

    public function actualizar() {
        //sanitizar la entrada de los datos
        $atributos = $this->sanitizarAtributos();

        $valores = [];
        foreach ($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }

        $query = "UPDATE " . static::$tabla . " SET "; 
        $query .=  join(', ', $valores );
        $query .= "WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 ";

        $resultado = self::$db->query($query); //este codigo siempre q interactue con la BD

        if ($resultado) {
            //erdireccionar al usuario (como el formulario queda lleno evitar q lo envien cada rato x q creen q no paso )
            //echo "Insertado correctamente";
            header('Location: /bienesraices/admin?resultado=2'); //no debe haber nada de html previo para redireccionar(usar poco)
        }
    }

    //Eliminar un registro
    public function eliminar() {
        //escapo para q no pongan codigo malicioso de inyeccion sql
        $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1"; 
        $resultado = self::$db->query($query);

        if ($resultado) {
            $this->borrarImagen();
            header('Location: /bienesraices/admin?resultado=3');
        }
        
    }

    //itera sobre $columnasDB, identificar y unir los atributos de la BD
    public function atributos() {
        $atributos = [];
        foreach(self::$columnasDB as $columna) {
            if ($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }

        return $atributos;
    }

    public function sanitizarAtributos() {
        $atributos = $this->atributos();
        //debuguear($atributos);
        $sanitizado = [];

        foreach ($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }

        return $sanitizado;
    }

    // subida de archivos
    public function setImage($imagen) {
        //elimina la imagen previa
        if ( !is_null($this->id ) ) {
            $this->borrarImagen();
        }

        //asignar al atributo de Imagen el nombre de la imagen
        if ($imagen) {
            $this->imagen = $imagen; //imagen q le vamos a pasar cuando llamemos este metodo
        }
    }

    //Eliminar imagen archivo
    public function borrarImagen() {
       //comprobar si existe el archibo
       $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
       if ($existeArchivo) {
           unlink(CARPETA_IMAGENES . $this->imagen);  //si lo encuentra elimina el archivo
       };
    }

    // validacion
    public static function getErrores() { //el metodo esta estatico no necesitamos nueva instancia en crear propiedad
        return self::$errores;
    }

    public function validar() {
        
        //validar si escribieron si no manda al arreglo de errores
    if (!$this->titulo) { //this lo q esta en el constructor, los atributos
        self::$errores[] = "Debes añadir un titulo"; //añade el error al final del arreglo, self lo estatico
    }

    if (!$this->precio) {
        self::$errores[] = "El Precio es obligatorio";
    }

    if (strlen($this->descripcion) < 50) {
        self::$errores[] = "La Descripcion es obligatoria, y debe tener al menos 50 caracteres";
    }

    if (!$this->habitaciones) {
        self::$errores[] = "El numero de habitaciones es obligatorio";
    }

    if (!$this->wc) {
        self::$errores[] = "El numero de Baños es obligatorio";
    }

    if (!$this->estacionamiento) {
        self::$errores[] = "El numero de estacionamiento es obligatorio";
    }

    if (!$this->vendedores_id) {
        self::$errores[] = "Elige un vendedor";
    }

    if (!$this->imagen) {
        self::$errores[] = 'la imagen es obligatoria';
    }
    
    return self::$errores;
 } 

//lista todas los(registros)
public static function all() {
    $query = "SELECT * FROM " . static::$tabla; //static hereda el metodo all y busca ese atributo donde se hereda, como puede ser propiedad o vendeor
    $resultado = self::consultarSQL($query);
    return $resultado;
    
}

//busca un registro por su id
public static function find($id) {
    $query = "SELECT * FROM " . static::$tabla . " WHERE id = $id";

    $resultado = self::consultarSQL($query);
    return array_shift($resultado);  //retorna el primer elemento de una arreglo xq todo esta en la q posicion del arreglo como un objeto
}

public static function consultarSQL($query) {
    //consultar la base de datos
    $resultado = self::$db->query($query);

    //iterar los resultados
    $array = [];
    while($registro = $resultado->fetch_assoc()) {
        $array[] = self::crearObjeto($registro);
    }


    //liberar la memoria
    $resultado->free();

    //retornar los resultados
    return $array;
}

    protected static function crearObjeto($registro) {
        $objeto = new static; //crea un nuevo objeto en la clase q esta heredando

        foreach ($registro as $key => $value) {
            if (property_exists($objeto, $key)) { //comparar el objeto q estoy creando si tiene el id, mapea los datos de arreglos hacia objetos q se quedan en memoria 
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }

    //sincronizxa el objeto en memoria con los cambios realizados por el usuario
    //leer todo el post leer todo el objeto q esta en memoria mapeanto titulo con titulo,etc, y reescribiendo las nuevas q el usuario puso actualizando
    public function sincronizar( $args = [] ) {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value) ) { //revisa de un objeto q un atributo exista 
                $this->$key = $value;
            }
        }
    }
}
