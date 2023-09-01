<?php
require_once '../vendor/autoload.php';
require_once '../Config/Config.php';

use Config\Database;
use Core\Routing\Router;
use Core\Routing\Route;
use Core\Routing\RouteCollection;

// Crea una instancia de RouteCollection para administrar las rutas
$routes = new RouteCollection();

$routes->add(new Route('GET', '/', 'App\Controllers\EmployeesController', 'index'));
// Create
$routes->add(new Route('POST', '/create', 'App\Controllers\EmployeesController', 'store'));
// Read
$routes->add(new Route('GET', '/show/{id}', 'App\Controllers\EmployeesController', 'show'));
// Update
$routes->add(new Route('POST', '/update/{id}', 'App\Controllers\EmployeesController', 'update')); //TODO: Ajustar para cambio a PUT
// Delete
$routes->add(new Route('POST', '/delete/{id}', 'App\Controllers\EmployeesController', 'delete')); //TODO: Ajustar para cambio a DELETE  

// Crea una instancia de Router con la colección de rutas
$router = new Router($routes);

// Obtén la URL solicitada por el usuario
$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Enruta la solicitud actual
$router->route($requestMethod, $requestUri);
