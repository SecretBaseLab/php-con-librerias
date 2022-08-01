<?php

namespace App\Controllers;

use App\Models\{job, project};

class IndexController extends BaseController{
    public function indexAction(){
        $nombre = "Darwin Bayas";
        $jobs = job::all();     //aqui lee los datos de la tabla donde apunta job mediante eloquent
        $project = project::all();

        //? usando closures = funcion anonima
        $limitMonths = 10;
        $filterFunction = function(array $job) use ($limitMonths) { //! se usa use porq $limitMonths no esta dentro del scope de la funcions
            return $job['months']>$limitMonths;
        };
        $jobs = array_filter( $jobs->toArray(), $filterFunction);

        // include "../views/index.php";
        return $this->renderHTML('index.twig',[
            'nombre' => $nombre,
            'jobs' => $jobs,
            'projects' => $project
        ]);
    }
}
