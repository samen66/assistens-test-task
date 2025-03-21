<?php

namespace AssistensTestTask\Routes;

class RouteHandler
{
    private array $routes = [];

    public function add(string $method, string $path, callable $handler, ?array $middlewares = null): void
    {
        $this->routes[$method][$path] = ['handler' => $handler, 'middlewares' => $middlewares];
    }

    public function dispatch(string $method, string $uri): void
    {
        if (!isset($this->routes[$method][$uri])) {
            http_response_code(404);
            return;
        }

        $route = $this->routes[$method][$uri];

        // Применяем Middlewares
        if (!empty($route['middlewares'])) {
            foreach ($route['middlewares'] as $middleware) {
                $middleware->handle();
            }
        }

        // Вызываем контроллер/обработчик
        call_user_func($route['handler']);
    }

}