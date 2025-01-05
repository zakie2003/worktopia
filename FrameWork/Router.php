<?php

namespace FrameWork;

use App\Controllers\HomeController;
use App\Controllers\ErrorController;

class Router
{
    protected $routes = [];

    /**
     * Add a route with a specific method.
     *
     * @param string $method
     * @param string $url
     * @param string $action
     */
    public function addRoute($method, $url, $action)
    {
        list($controller, $controllerMethod) = explode("@", $action);
        $this->routes[] = [
            "method" => $method,
            "url" => $url,
            "controller" => $controller,
            "controllerMethod" => $controllerMethod
        ];
    }

    /**
     * Add a GET route.
     *
     * @param string $url
     * @param string $controller
     */
    public function get($url, $controller)
    {
        $this->addRoute("GET", $url, $controller);
    }

    /**
     * Add a POST route.
     *
     * @param string $url
     * @param string $controller
     */
    public function post($url, $controller)
    {
        $this->addRoute("POST", $url, $controller);
    }

    /**
     * Add a PUT route.
     *
     * @param string $url
     * @param string $controller
     */
    public function put($url, $controller)
    {
        $this->addRoute("PUT", $url, $controller);
    }

    /**
     * Add a DELETE route.
     *
     * @param string $url
     * @param string $controller
     */
    public function delete($url, $controller)
    {
        $this->addRoute("DELETE", $url, $controller);
    }

    /**
     * Match the given URL and execute the corresponding controller action.
     *
     * @param string $url
     */
    public function dispatch($url)
    {
        $requestMethod = $_SERVER["REQUEST_METHOD"];

        if($requestMethod == "POST" && isset($_POST["_method"])){
            $requestMethod = strtoupper($_POST["_method"]);
        }
        foreach ($this->routes as $route) {
            $routeSegment = explode("/", trim($route["url"], "/"));
            $urlSegment = explode("/", trim($url, "/"));

            $match = true;
            $params = [];

            // Check if method and segment counts match
            if (count($routeSegment) === count($urlSegment) && strtoupper($route["method"]) === strtoupper($requestMethod)) {
                for ($i = 0; $i < count($urlSegment); $i++) {
                    // Check static parts of the route
                    if ($routeSegment[$i] !== $urlSegment[$i] && !preg_match("/\{(.+?)\}/", $routeSegment[$i])) {
                        $match = false;
                        break;
                    }

                    // Extract parameters
                    if (preg_match("/\{(.+?)\}/", $routeSegment[$i], $matches)) {
                        $params[$matches[1]] = $urlSegment[$i];
                    }
                }
            } else {
                $match = false;
            }

            // If a match is found
            if ($match) {
                $controllerClass = 'App\\Controllers\\' . $route["controller"];
                $controllerMethod = $route["controllerMethod"];

                if (class_exists($controllerClass)) {
                    $controllerInstance = new $controllerClass();
                    if (method_exists($controllerInstance, $controllerMethod)) {
                        // Call the controller method with parameters
                        $controllerInstance->$controllerMethod($params);
                        return;
                    }
                }

                // Controller or method not found
                ErrorController::NotFound();
                return;
            }
        }

        // No route matched
        ErrorController::NotFound();
    }
}

?>
