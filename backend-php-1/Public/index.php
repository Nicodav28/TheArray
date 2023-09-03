<?php
require_once '../vendor/autoload.php';
require_once '../Config/Config.php';

use Config\Database;
use Core\Routing\Router;
use Core\Routing\Route;
use Core\Routing\RouteCollection;

// Create an instance of RouteCollection to manage routes
$routes = new RouteCollection();

// Define routes for various HTTP methods and URI patterns
$routes->add(new Route('GET', '/', 'App\Controllers\EmployeesController', 'index')); // Index
$routes->add(new Route('POST', '/create', 'App\Controllers\EmployeesController', 'store')); // Create
$routes->add(new Route('GET', '/show/{id}', 'App\Controllers\EmployeesController', 'show')); // Read
$routes->add(new Route('POST', '/update/{id}', 'App\Controllers\EmployeesController', 'update')); // Update (TODO: Adjust for PUT)
$routes->add(new Route('POST', '/delete/{id}', 'App\Controllers\EmployeesController', 'delete')); // Delete (TODO: Adjust for DELETE)

// Create an instance of Router with the collection of routes
$router = new Router($routes);

// Get the requested URL and HTTP method from the server
$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Route the current request
$router->route($requestMethod, $requestUri);
