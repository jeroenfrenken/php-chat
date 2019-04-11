<?php
namespace App\Event;

class Request
{

    private $_container;

    public function __construct(array $container)
    {
        $this->_container = $container;
    }

    public function handle()
    {
        $routes = $this->_container['config']['routes'];

        foreach ($routes as $route) {
            if ($route['url'] === $_SERVER['REQUEST_URI']) {
                list($controller, $method) = explode('::', $route['controller'], 2);
                $controller = new $controller();
                $controller->{$method}($this->_container);
                return;
            }
        }
        //TODO: 404
    }

}
