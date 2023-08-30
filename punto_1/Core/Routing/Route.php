<?php

namespace Core\Routing;

class Route
{
    protected $method;
    protected $uri;
    protected $controller;
    protected $methodToCall;

    public function __construct($method, $uri, $controller, $methodToCall)
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->controller = $controller;
        $this->methodToCall = $methodToCall;
    }

    public function match($requestMethod, $requestUri)
    {
        if ($this->method !== $requestMethod) {
            return false;
        }

        $pattern = str_replace('/', '\/', $this->uri);
        $pattern = preg_replace('/\{([^}]+)\}/', '(?P<\1>[^\/]+)', $pattern);
        $pattern = '/^' . $pattern . '$/';

        return preg_match($pattern, $requestUri);
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getMethodToCall()
    {
        return $this->methodToCall;
    }
}
