<?php

namespace Core\Routing;

class Route
{
    protected $method;
    protected $uriPattern; // Patrón de la URL con parámetros dinámicos
    protected $controller;
    protected $methodToCall;

    public function __construct($method, $uriPattern, $controller, $methodToCall)
    {
        $this->method = $method;
        $this->uriPattern = $this->buildPattern($uriPattern); // Usamos el patrón construido
        $this->controller = $controller;
        $this->methodToCall = $methodToCall;
    }

    public function match($requestMethod, $requestUri)
    {
        if ($this->method !== $requestMethod || preg_match('#\.(css|js|png|jpg|jpeg|gif)$#i', $requestUri)) {
            return null;
        }

        if (preg_match($this->uriPattern, $requestUri, $matches)) {
            return $matches;
        }

        return null; // No se encontró coincidencia
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getMethodToCall()
    {
        return $this->methodToCall;
    }

    protected function buildPattern($uriPattern)
    {
        // Escapa los caracteres especiales en el patrón
        $pattern = preg_replace('#\{([^}]+)\}#', '(?P<\1>[^/]+)', $uriPattern);

        // Agrega delimitadores '/' y anclajes para coincidir con la URL completa
        return '#^' . $pattern . '$#';
    }
}
