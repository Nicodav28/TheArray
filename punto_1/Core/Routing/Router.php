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
        if (preg_match('#\.(css|js)$#i', $requestUri)) {
            $this->serveStaticFile($requestUri);
            return;
        }

        $matchingRoutes = $this->routes->match($requestMethod, $requestUri);

        if (!empty($matchingRoutes)) {
            foreach ($matchingRoutes as $match) {
                $route = $match['route'];
                $params = $match['params'];
                $controller = $route->getController();
                $methodToCall = $route->getMethodToCall();

                if (method_exists($controller, $methodToCall)) {
                    $controllerInstance = new $controller();
                    call_user_func_array([$controllerInstance, $methodToCall], [$params['id']]);
                    return; // Importante: detiene la ejecución después de manejar la coincidencia elegida
                }
            }
        }

        // Si no se encontró ninguna ruta coincidente
        $this->handleNotFoundError();
    }

    private function serveStaticFile($requestUri)
    {
        // Ruta al directorio de archivos estáticos
        $staticDir = __DIR__ . '/Public';

        $staticFilePath = $staticDir . $requestUri;

        if (file_exists($staticFilePath)) {
            $this->setContentType($requestUri);
            readfile($staticFilePath);
        } else {
            $this->handleNotFoundError();
        }
    }

    private function setContentType($requestUri)
    {
        if (preg_match('#\.css$#i', $requestUri)) {
            header('Content-Type: text/css');
        } elseif (preg_match('#\.js$#i', $requestUri)) {
            header('Content-Type: application/javascript');
        }
    }

    private function handleNotFoundError()
    {
        header("HTTP/1.0 404 Not Found");
        echo "Página no encontrada";
    }
}
