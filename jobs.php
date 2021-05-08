<?php
//accediendo a los subespacion
// use App\Models\job;
// use app\models\project;

// require_once "vendor/autoload.php";
use App\Models\{job, project};

// $project_Lib = new lib\project();

//experiencia de trabajo
/* $job_datos = [
    ["", "Un lenguaje facil de aprender", true, 15],
    ["JAVA", "Un lenguaje facil de aprender", true, 10],
    ["PYTHON", "Un lenguaje facil de aprender", true, 30]
]; */
// print_r(unserialize(serialize($job_datos)));

$jobs = job::all();     //aqui lee los datos de la tabla donde apunta job mediante eloquent
/* $jobs_array = array();
foreach ($job_datos as $key => $fila) {
    $jobs_array[$key] = new job($fila);  
} */

//proyectos
$project = project::all();

/* $project_datos = [
    ["proyecto 1", "descripcion 1"]
];
$project_array = array();
foreach ($project_datos as $key => $fila) {
    //llamando a la clase a travez del namespace
    // $project_array[$key] = new App\Models\project($fila);
    $project_array[$key] = new project($fila);  //aqui se llama al constructor de padre a menos q se diga lo contrario
} */

