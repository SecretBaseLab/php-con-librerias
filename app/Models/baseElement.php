<?php
namespace App\Models;

class baseElement implements imprimible{
    //atributos
    protected $title;
    public $description, $visible = true, $months;

    public function __construct($jobs){
        list(
            $_title,
            $this->description
        ) = $jobs;
        $this->setTitle($_title);
    }

    //metodos -> lo q hace
    //fun para asignar el titulo a una var privada
    public function setTitle($_title){
        $this->title = $_title == ""? 'N/A' : $_title;
    }

    public function getTitle(){
        return $this->title;
    }

    public function getDurationAsString(){
        $years = floor($this->months / 12);
        $extraMonths = $this->months % 12;

        return "$years Años y $extraMonths Meses";
    }

    //fun llamada por defecto al llamar a la instancia sin refeciar a un metodo o atrib
    public function __toString(){
        return $this->title;
    }    

    //fun q se ejecuta si no encuentra el metodo buscado pasando el nombre del metodo no encontrado y sus paramtros en un array
    public function __call($mostrarTitle, $arguments){
        print_r($arguments);
    }

    //fun q se ejecuta cuando se llama a un atributo no publico
    // public function __get($atrib){
    //     return $this->$atrib;
    // }

    //fun q se ejecuta cuando se quiere asignar un valor a una var no publica
    public function __set($atrib, $value){
        $this->$atrib = $value;
    }

    public function __sleep(){
        echo "estoy en sleep";
        return array('dsn', 'username', 'password');
    }

    public function __wakeup(){
        $this->connect();
    }

    //metodos de la interface imprimible
    public function getdescription(){
        return "Descripcion: ".$this->description;
    }
}