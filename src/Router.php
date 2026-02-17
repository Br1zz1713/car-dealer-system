<?php

namespace App;

class Router
{
    protected $routes = [];

    public function get($uri, $action)
    {
        $this->addRoute('GET', $uri, $action);
    }

    public function post($uri, $action)
    {
        $this->addRoute('POST', $uri, $action);
    }

    protected function addRoute($method, $uri, $action)
    {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'action' => $action
        ];
    }

    public function dispatch()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];

        // Strip query string (?foo=bar)
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        
        // robustly strip the script path (e.g. /public or /subdir) to get the relative route
        $scriptPath = dirname($_SERVER['SCRIPT_NAME']);
        // Normalize slashes
        $scriptPath = str_replace('\\', '/', $scriptPath);
        if ($scriptPath !== '/' && strpos($uri, $scriptPath) === 0) {
            $uri = substr($uri, strlen($scriptPath));
        }

        // Just in case /public is still there explicitly
        if (strpos($uri, '/public') === 0) {
            $uri = substr($uri, 7);
        }

        // Remove trailing slash
        $uri = rtrim($uri, '/');
        if ($uri === '') {
            $uri = '/';
        }

        foreach ($this->routes as $route) {
            if ($route['method'] === $method) {
                // Check if route matches URI pattern (e.g., /vehicle/{id})
                $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([a-zA-Z0-9_]+)', $route['uri']);
                $pattern = "@^" . $pattern . "$@D";

                if (preg_match($pattern, $uri, $matches)) {
                    array_shift($matches); // Remove full match
                    
                    list($controller, $method) = explode('@', $route['action']);
                    $controllerClass = "App\\Controllers\\$controller";
                    
                    if (class_exists($controllerClass)) {
                        $controllerInstance = new $controllerClass();
                        call_user_func_array([$controllerInstance, $method], $matches);
                        return;
                    }
                }
            }
        }

        http_response_code(404);
        echo "404 Not Found";
    }
}
