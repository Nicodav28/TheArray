<?php

namespace Core\Routing;

class Route
{
    protected $method;
    protected $uriPattern; // URL pattern with dynamic parameters
    protected $controller;
    protected $methodToCall;

    public function __construct($method, $uriPattern, $controller, $methodToCall)
    {
        $this->method = $method;
        $this->uriPattern = $this->buildPattern($uriPattern); // Use the constructed pattern
        $this->controller = $controller;
        $this->methodToCall = $methodToCall;
    }

    /**
     * Match the route against the provided request method and URI.
     *
     * @param string $requestMethod The HTTP request method (e.g., GET, POST).
     * @param string $requestUri    The requested URI.
     *
     * @return array|null An array of matched route parameters or null if no match is found.
     */
    public function match($requestMethod, $requestUri)
    {
        // Check if the request method and URI match the route
        if ($this->method !== $requestMethod || preg_match('#\.(css|js|png|jpg|jpeg|gif)$#i', $requestUri)) {
            return null;
        }

        // Try to match the URI against the route's URI pattern
        if (preg_match($this->uriPattern, $requestUri, $matches)) {
            return $matches;
        }

        return null; // No match found
    }

    /**
     * Get the controller associated with the route.
     *
     * @return string The name of the controller.
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * Get the controller method to call for the route.
     *
     * @return string The name of the controller method.
     */
    public function getMethodToCall()
    {
        return $this->methodToCall;
    }

    /**
     * Build a regular expression pattern from the provided URI pattern.
     *
     * @param string $uriPattern The URI pattern with dynamic parameters.
     *
     * @return string The constructed regular expression pattern.
     */
    protected function buildPattern($uriPattern)
    {
        // Escape special characters in the pattern
        $pattern = preg_replace('#\{([^}]+)\}#', '(?P<\1>[^/]+)', $uriPattern);

        // Add delimiters '/' and anchors to match the entire URL
        return '#^' . $pattern . '$#';
    }
}
