<?php

namespace Core\Routing;

class RouteCollection
{
    protected $routes = [];

    public function add(Route $route)
    {
        $this->routes[] = $route;
    }

    public function match($requestMethod, $requestUri)
    {
        $matchingRoutes = [];

        foreach ($this->routes as $route) {

            $params = $route->match($requestMethod, $requestUri);

            if ($params !== null) {
                // Almacena la ruta coincidente y sus parámetros
                $matchingRoutes[] = [
                    'route' => $route,
                    'params' => $params,
                ];
            }
        }

        return $matchingRoutes;
    }
}
