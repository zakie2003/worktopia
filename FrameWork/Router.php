<?php

namespace FrameWork;

use App\Controllers\HomeController;
use App\Controllers\ErrorController;
use FrameWork\Middleware\Authorize;

class Router
{
    protected $routes = [];

    /**
     * Add a route with a specific method.
     *
     * @param string $method
     * @param string $url
     * @param string $action
     * @param array $middleware
     */
    public function addRoute($method, $url, $action, $middleware = [])
    {
        list($controller, $controllerMethod) = explode("@", $action);
        $this->routes[] = [
            "method" => $method,
            "url" => $url,
            "controller" => $controller,
            "controllerMethod" => $controllerMethod,
            "middleware" => $middleware
        ];
    }

    /**
     * Add a GET route.
     *
     * @param string $url
     * @param string $controller
     * @param array $middleware
     */
    public function get($url, $controller, $middleware = [])
    {
        $this->addRoute("GET", $url, $controller, $middleware);
    }

    /**
     * Add a POST route.
     *
     * @param string $url
     * @param string $controller
     */
    public function post($url, $controller,$middleware = [])
    {
        $this->addRoute("POST", $url, $controller, $middleware);
    }

    /**
     * Add a PUT route.
     *
     * @param string $url
     * @param string $controller
     */
    public function put($url, $controller, $middleware = [])
    {
        $this->addRoute("PUT", $url, $controller,$middleware);
    }

    /**
     * Add a DELETE route.
     *
     * @param string $url
     * @param string $controller
     */
    public function delete($url, $controller, $middleware = []) 
    {
        $this->addRoute("DELETE", $url, $controller, $middleware);
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

                foreach ($route["middleware"] as $role) {
                    (new Authorize())->handle($role);
                }

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
