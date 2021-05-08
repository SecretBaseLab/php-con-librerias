<?php

namespace App\Controllers;

use App\Models\{job, project};

class IndexController extends BaseController{
    public function indexAction(){
        $nombre = "Darwin Bayas";
        $jobs = job::all();     //aqui lee los datos de la tabla donde apunta job mediante eloquent
        $project = project::all();

        // include "../views/index.php";
        return $this->renderHTML('index.twig',[
            'nombre' => $nombre,
            'jobs' => $jobs,
            'projects' => $project
        ]);
    }
}
