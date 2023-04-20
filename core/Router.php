<?php

class Router
{
    protected $routes = [];

    public function add($method, $uri, $controller)
    {
        $this->routes[] = [
            'uri' => $uri,
            'controller' => $controller,
            'method' => $method
        ];

        return $this;
    }

    public function get($uri, $controller)
    {
        return $this->add('GET', $uri, $controller);
    }

    public function post($uri, $controller)
    {
        return $this->add('POST', $uri, $controller);
    }

    public function delete($uri, $controller)
    {
        return $this->add('DELETE', $uri, $controller);
    }

    public function patch($uri, $controller)
    {
        return $this->add('PATCH', $uri, $controller);
    }

    public function put($uri, $controller)
    {
        return $this->add('PUT', $uri, $controller);
    }

    public function route($path, $method)
    {
        // ------------------------------------------------------
        // path example: 
        // http://localhost/en/product/test-a
        // ------------------------------------------------------

        $path_segments = explode('/', $path);

        // remove the empty first element from the array
        array_shift($path_segments);

        $locale = ( isset($path_segments[0]) && !empty($path_segments[0]) ) ? $path_segments[0] : "";
        // redirects to english if no lacale is passed in the URL
        if (!$locale ) {
            header('Location: /en');
            exit();
        }
        else if ($locale !== 'en' && $locale !== 'ptbr') {
            $this->abort();
        }

        $dataset = ( isset($path_segments[1]) && !empty($path_segments[1]) ) ? $path_segments[1] : "";
        $path = ( isset($path_segments[2]) && !empty($path_segments[2]) ) ? $path_segments[2] : "";

        $uri = "/" . $dataset;

        // dd(
        //     [
        //         "locale" => $locale,
        //         "dataset" => $dataset,
        //         "path" => $path,
        //         "uri" => $uri
        //     ]
        // );

        foreach ($this->routes as $route) {
            if ($route['uri'] === $uri && $route['method'] === strtoupper($method)) {
                return require base_path($route['controller']);
            }
        }

        $this->abort();
    }

    protected function abort($code = 404)
    {
        http_response_code($code);

        require base_path("views/{$code}.php");

        die();
    }
}
