<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// class job extends baseElement{
class job extends Model{
    /* public function __construct($datos){ //sobrescribiendo el construct
        $datos[0] = "Trabajo: ".$datos[0];
        parent::__construct($datos);    //llamando al construct padre pa inicialuzar sus valores
    } */
    protected $table = 'jobs';

    //metodo modificado = poliformismo
    public function getDurationAsString(){
        $years = floor($this->months / 12);
        $extraMonths = $this->months % 12;

        return "Duración del trabajo $years Años y $extraMonths Meses";
    }
}