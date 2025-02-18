<?php
namespace App\Core;

class Router {
    private $routes = [];

    public function addRoute($method, $path, $handler) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler
        ];
    }

    public function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $route['path'] === $path) {
                list($controller, $action) = explode('@', $route['handler']);
                $controllerClass = "App\\Controllers\\{$controller}";
                
                if (!class_exists($controllerClass)) {
                    throw new \Exception("Controller {$controllerClass} not found");
                }

                $controllerInstance = new $controllerClass();
                
                if (!method_exists($controllerInstance, $action)) {
                    throw new \Exception("Action {$action} not found in controller {$controllerClass}");
                }

                return $controllerInstance->$action();
            }
        }

        // If no route matches, show 404 error
        header("HTTP/1.0 404 Not Found");
        include __DIR__ . '/../Views/errors/404.php';
    }
}
