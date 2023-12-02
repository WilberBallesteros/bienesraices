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

    public function validar() {
        
        if (!$this->nombre) { //this lo q esta en el constructor, los atributos
            self::$errores[] = "El Nombre es obligatorio"; //añade el error al final del arreglo, self lo estatico
        }

        if (!$this->apellido) { 
            self::$errores[] = "El Apellido es obligatorio"; 
        }

        if (!$this->telefono) { 
            self::$errores[] = "El Teléfono es obligatorio"; 
        }

        //que el usuario no ponga texto en el numero de tel
        //exprecion regular es la forma de buscar un patron dentro de un texto
        
        // if (!preg_match('/[0-9]{10}/', $this->telefono)) { //extencion fija, de 10 digitos q sena numeros del 0 al 9
        //     self::$errores[] = "Formato no válido"; 
        // }

        if(!preg_match("/[0-9]{10}/", $this->telefono) or strlen($this->telefono) > 10) {
            self::$errores[] = "Formato de teléfono no válido";
        }

        return self::$errores;
    }
}