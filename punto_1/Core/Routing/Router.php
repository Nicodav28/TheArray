<?php

namespace Core\Routing;

class Router
{
    protected $routes;

    public function __construct(RouteCollection $routes)
    {
        $this->routes = $routes;
    }

    public function route($requestMethod, $requestUri)
    {
        $route = $this->routes->match($requestMethod, $requestUri);

        if ($route) {
            $controller = $route->getController();
            $methodToCall = $route->getMethodToCall();

            $controllerInstance = new $controller();
            $controllerInstance->$methodToCall();
        } else {
            // Manejo de errores 404
            header("HTTP/1.0 404 Not Found");
            echo "Página no encontrada";
        }
    }
}
