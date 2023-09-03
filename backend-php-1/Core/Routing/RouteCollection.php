<?php

namespace Core\Routing;

class RouteCollection
{
    protected $routes = [];

    /**
     * Add a route to the collection.
     *
     * @param Route $route The route to add to the collection.
     */
    public function add(Route $route)
    {
        $this->routes[] = $route;
    }

    /**
     * Match the request method and URI against the registered routes.
     *
     * @param string $requestMethod The HTTP request method (e.g., GET, POST).
     * @param string $requestUri    The requested URI.
     *
     * @return array An array of matching routes and their parameters.
     */
    public function match($requestMethod, $requestUri)
    {
        $matchingRoutes = [];

        foreach ($this->routes as $route) {
            // Attempt to match the route against the request method and URI
            $params = $route->match($requestMethod, $requestUri);

            if ($params !== null) {
                // Store the matching route and its parameters
                $matchingRoutes[] = [
                    'route' => $route,
                    'params' => $params,
                ];
            }
        }

        return $matchingRoutes;
    }
}
