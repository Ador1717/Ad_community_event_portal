<?php
namespace routers;

class Router
{
    private $routes = [];

    public function addRoute($uri, $controllerMethod)
    {
        $this->routes[$uri] = $controllerMethod;
    }
    public function route($urlPath)
    {
        if (array_key_exists($urlPath, $this->routes)) {
            $action = $this->routes[$urlPath];
            if (is_callable($action)) {
                call_user_func($action);
            } else {
                echo 'Error: Action not callable.';
            }
        } else {
            echo '404 Not Found';
        }
    }
}
?>
