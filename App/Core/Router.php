<?php
namespace App\Core;

class Router {
    private $routes = [];

    public function get($path, $callback) {
        $this->routes['GET'][$path] = $callback;
    }

    public function post($path, $callback) {
        $this->routes['POST'][$path] = $callback;
    }

    public function resolve() {
        $method = $_SERVER['REQUEST_METHOD'];
        
        // Limpar a URI para pegar apenas o caminho sem a baseurl e query strings
        // Como não estamos usando framework, vamos basear no SCRIPT_NAME ou similar
        $basepath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
        $uri = substr($_SERVER['REQUEST_URI'], strlen($basepath));
        
        if (strstr($uri, '?')) {
            $uri = substr($uri, 0, strpos($uri, '?'));
        }
        
        $path = '/' . trim($uri, '/');
        
        $callback = $this->routes[$method][$path] ?? false;

        if ($callback === false) {
            http_response_code(404);
            echo "404 Not Found";
            exit;
        }

        if (is_array($callback)) {
            $controller = new $callback[0]();
            $method = $callback[1];
            call_user_func([$controller, $method]);
        } else {
            call_user_func($callback);
        }
    }
}
