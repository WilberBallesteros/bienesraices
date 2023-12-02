<?php

namespace App;

use GuzzleHttp\Psr7\Query;

class Propiedad extends ActiveRecord{

    protected static $tabla = 'propiedades'; //tabla
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedores_id']; //columnas

    //atributos
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

    //constructor
    public function __construct($args = []) 
    {
        $this->id = $args['id'] ?? null; //como el id es autoincrementable ni se deberia usar
        $this->titulo = $args['titulo'] ?? null;  //?? '' en caso de q no este el titulo q lo pase vacio
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedores_id = $args['vendedores_id'] ?? '';
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
        self::$errores[] = 'la imagen de la propiedad es obligatoria';
    }
    
    return self::$errores;
 } 

}