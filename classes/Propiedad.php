<?php

namespace App;

use GuzzleHttp\Psr7\Query;

class Propiedad {

    //base de datos
    protected  static $db; //static por q no requerimis diferentes instancias o conexiones
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedores_id']; //q forma vana tener los datos, q columnas va a tener

    // errores o validaciones
    protected static $errores = [];


    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedores_id;

     //definir la conexion a la BD
    public static function setDB($database) {
        self::$db = $database;  //self hace referencia a los atributos estaticos de la misma clase
    }

    public function __construct($args = []) 
    {
        $this->titulo = $args['titulo'] ?? '';  //?? '' en caso de q no este el titulo q lo pase vacio
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedores_id = $args['vendedores_id'] ?? 1;
    }

    public function guardar() {

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
        $query = "INSERT INTO propiedades($columnas) VALUES ('$fila')";

        //debuguear($query);  //queda todo el script de insert into ... completo

        $resultado = self::$db->query($query);
        return $resultado;
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
        //asignar al atributo de Imagen el nombre de la imagen
        if ($imagen) {
            $this->imagen = $imagen; //imagen q le vamos a pasar cuando llamemos este metodo
        }
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

//lista todas las propiedades
public static function all() {
    $query = "SELECT * FROM propiedades";

    $resultado = self::consultarSQL($query);

    return $resultado;
    
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
        $objeto = new self; //una nueva propiedad de la clase padre Propiedad una nueva instancia

        foreach ($registro as $key => $value) {
            if (property_exists($objeto, $key)) { //comparar el objeto q estoy creando si tiene el id, mapea los datos de arreglos hacia objetos q se quedan en memoria 
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }

}