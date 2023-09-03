<?php

namespace Core\Routing;

class Router
{
    protected $routes;

    public function __construct(RouteCollection $routes)
    {
        $this->routes = $routes;
    }

    /**
     * Route the incoming request to the appropriate controller method.
     *
     * @param string $requestMethod The HTTP request method (e.g., GET, POST).
     * @param string $requestUri    The requested URI.
     */
    public function route($requestMethod, $requestUri)
    {
        // Serve static files (e.g., CSS, JS)
        if (preg_match('#\.(css|js)$#i', $requestUri)) {
            $this->serveStaticFile($requestUri);
            return;
        }

        // Find matching routes for the request
        $matchingRoutes = $this->routes->match($requestMethod, $requestUri);

        if (!empty($matchingRoutes)) {
            foreach ($matchingRoutes as $match) {
                $route = $match['route'];
                $params = $match['params'];
                $controller = $route->getController();
                $methodToCall = $route->getMethodToCall();

                // Check if the controller method exists and call it
                if (method_exists($controller, $methodToCall)) {
                    $controllerInstance = new $controller();
                    call_user_func_array([$controllerInstance, $methodToCall], [$params['id']]);
                    return; // Important: stop execution after handling the chosen match
                }
            }
        }

        // If no matching route was found, handle a 404 Not Found error
        $this->handleNotFoundError();
    }

    /**
     * Serve a static file if it exists in the public directory.
     *
     * @param string $requestUri The requested URI.
     */
    private function serveStaticFile($requestUri)
    {
        // Path to the directory of static files
        $staticDir = __DIR__ . '/Public';

        $staticFilePath = $staticDir . $requestUri;

        if (file_exists($staticFilePath)) {
            $this->setContentType($requestUri);
            readfile($staticFilePath);
        } else {
            $this->handleNotFoundError();
        }
    }

    /**
     * Set the Content-Type header based on the file extension.
     *
     * @param string $requestUri The requested URI.
     */
    private function setContentType($requestUri)
    {
        if (preg_match('#\.css$#i', $requestUri)) {
            header('Content-Type: text/css');
        } elseif (preg_match('#\.js$#i', $requestUri)) {
            header('Content-Type: application/javascript');
        }
    }

    /**
     * Handle a 404 Not Found error.
     */
    private function handleNotFoundError()
    {
        header("HTTP/1.0 404 Not Found");
        echo "Page not found";
    }
}
