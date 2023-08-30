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
        foreach ($this->routes as $route) {
            if ($route->match($requestMethod, $requestUri)) {
                return $route;
            }
        }

        return null;
    }
}
