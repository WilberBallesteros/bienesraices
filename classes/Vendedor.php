<?php

namespace App;

class Vendedor extends ActiveRecord {

    protected static $tabla = 'vendedores'; //nombre tabla bd
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'telefono']; //q forma vana tener los datos, q columnas va a tener

    //atributos
    public $id;
    public $nombre;
    public $apellido;
    public $telefono;

    //constructor
    public function __construct($args = []) 
    {
        $this->id = $args['id'] ?? null; //como el id es autoincrementable ni se deberia usar
        $this->nombre = $args['nombre'] ?? null;  //?? '' en caso de q no este el nombre q lo pase vacio
        $this->apellido = $args['apellido'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
    }
}