<?php
require_once '../vendor/autoload.php';
require_once '../Config/Config.php';

use Config\Database;
use Core\Routing\Router;
use Core\Routing\Route;
use Core\Routing\RouteCollection;

// $performConnection = new Database();

// print_r($performConnection->performConnection());
// die();

// Crea una instancia de RouteCollection para administrar las rutas
$routes = new RouteCollection();

// Agrega rutas
$routes->add(new Route('GET', '/inicio', 'MiControlador', 'metodoInicio'));
$routes->add(new Route('GET', '/acerca', 'MiControlador', 'metodoAcerca'));

// Crea una instancia de Router con la colección de rutas
$router = new Router($routes);

// Obtén la URL solicitada por el usuario
$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Enruta la solicitud actual
$router->route($requestMethod, $requestUri);
