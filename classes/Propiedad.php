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
}