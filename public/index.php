<?php
// ?pa activar la visualizacion de errores en caso el servidor tenga desactivado
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

//? conexion con la base de datos mediante el orm eloquent
require_once "../vendor/autoload.php";

session_start();

//usando vars de entorno pa acceder a la config de la base
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;
$capsule->addConnection([
    'driver'    => $_ENV['DB_DRIVER'],
    'host'      => $_ENV['DB_HOST'],
    'database'  => $_ENV['DB_NAME'],
    'username'  => $_ENV['DB_USER'],
    'password'  => $_ENV['DB_PASS'],
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);
// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();
// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();

//? manejador del request con laminas 
$request = Laminas\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);
// print_r($request->getUri()->getPath());
//! dir_raiz hay q cambiar en caso el proyecto no este en la raiz del servidor, pero es mejor cambiar la config de apache en este caso httpd.conf y poner la ruta donde esta el proyecto y asi evitas usar esa var
$dir_raiz = '/';   //? ruta riaz del proyecto

//? router con aura router
use Aura\Router\RouterContainer;
use Laminas\Diactoros\Response\RedirectResponse;

$routerContainer = new RouterContainer();

$map = $routerContainer->getMap();      //? generador del mapa de rutas
$map->get('index', $dir_raiz, [
    "controller" => "App\Controllers\IndexController",
    "action" => "indexAction"
]);

$map->get('addJobs', $dir_raiz . 'jobs/add', [
    "controller" => "App\Controllers\JobsController",
    "action" => "getAddJobAction",
    "auth" => true
]);
$map->post('saveJobs', $dir_raiz . 'jobs/add', [
    "controller" => "App\Controllers\JobsController",
    "action" => "getAddJobAction"
]);

$map->get('addProjects', $dir_raiz . 'projects/add', [
    "controller" => "App\Controllers\ProjectsController",
    "action" => "getAddProjectAction",
    "auth" => true
]);
$map->post('saveProjects', $dir_raiz . 'projects/add', [
    "controller" => "App\Controllers\ProjectsController",
    "action" => "getAddProjectAction"
]);

$map->get('addUsers', $dir_raiz . 'users/add', [
    "controller" => "App\Controllers\UsersController",
    "action" => "getAddUserAction",
    "auth" => true
]);
$map->post('saveUsers', $dir_raiz . 'users/save', [
    "controller" => "App\Controllers\UsersController",
    "action" => "postSaveUserAction"
]);

$map->get('loginForm', $dir_raiz . 'login', [
    "controller" => "App\Controllers\AuthController",
    "action" => "getloginAction"
]);
$map->post('auth', $dir_raiz . 'auth', [
    "controller" => "App\Controllers\AuthController",
    "action" => "postLoginAction"
]);
$map->get('logoutForm', $dir_raiz . 'logout', [
    "controller" => "App\Controllers\AuthController",
    "action" => "getlogoutAction"
]);

$map->get('admin', $dir_raiz . 'admin', [
    "controller" => "App\Controllers\AdminController",
    "action" => "getIndexAction",
    "auth" => true
]);


$matcher = $routerContainer->getMatcher();

$route = $matcher->match($request);

if (!$route) {
    echo 'no route';
} else {
    // print_r( $route->handler);
    //recibe el array con el namesapce y la accion/metodo de esa clase
    $handlerData = $route->handler;
    $controllerName = $handlerData['controller'];
    $actionName = $handlerData['action'];
    $needsAuth = $handlerData['auth'] ?? false;

    //autenticacion
    $sessionUserId = $_SESSION['userId'] ?? null;
    if ($needsAuth && !$sessionUserId) {    //? niega el acceso si no esta logeado
        // echo 'protected route';
        $response = new RedirectResponse('/');                            
    }else{
        $controller = new $controllerName;      //genera una instancia de esa clase
        $response = $controller->$actionName($request);             //llama al metodo y recibe un obj response
    }

    //imprimendo los headers del response
    foreach ($response->getHeaders() as $name => $values) {
        foreach ($values as $value) {
            header(sprintf('%s: %s', $name, $value), false);
        }
    }

    http_response_code($response->getStatusCode());   //asignando el status code al response
    echo $response->getBody();  //obtiene el cuerpo html del response
}
// $failedRoute = $matcher->getFailedRoute();
// print_r($failedRoute);

//? emulando un router
/* $route = $_GET['route'] ?? "/";  //? si esta definido y tiene un valor
if ($route == "/")
    require "../index.php";
elseif($route = "addJob")
    require "../addJob.php"; */
