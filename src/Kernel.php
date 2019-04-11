<?php
namespace JeroenFrenken\Chat;

use JeroenFrenken\Chat\Repository\UserRepository;
use Medoo\Medoo;

class Kernel
{

    private $_container;

    public function __construct(array $config)
    {
        $this->buildContainer($config);
    }

    private function buildContainer(array $config)
    {
        $this->_container = [];
        $this->_container['config'] = $config;
        $this->_container['repository']['user'] = new UserRepository($config['database']);
    }

    private function loadController()
    {
        $routes = $this->_container['config']['routes'];

        foreach ($routes as $route) {
            if ($route['url'] === $_SERVER['REQUEST_URI']) {
                list($controller, $method) = explode('::', $route['controller'], 2);
                $controller = new $controller($this->_container);
                $controller->{$method}();
                return;
            }
        }
    }

    public function run()
    {
        $this->loadController();
    }

}
