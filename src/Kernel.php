<?php
namespace JeroenFrenken\Chat;

class Kernel
{

    private $_container;

    public function __construct(array $routesConfig, array $databaseConfig)
    {
        $this->buildContainer($routesConfig, $databaseConfig);
    }

    private function buildContainer(array $routesConfig, array $databaseConfig)
    {
        $this->_container = [];
        $this->_container['config']['routes'] = $routesConfig;
        $this->_container['config']['database'] = $databaseConfig;
    }

    private function loadController()
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
    }

    public function run()
    {
        $this->loadController();
    }

}
