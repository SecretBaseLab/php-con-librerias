<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class project extends Model{
    //tabla a la q apunta eloquent
    protected $table = "projects";

    public function getDurationAsString(){
        $years = floor($this->months / 12);
        $extraMonths = $this->months % 12;

        return "$years Años y $extraMonths Meses";
    }
}