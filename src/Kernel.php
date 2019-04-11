<?php
namespace JeroenFrenken\Chat;

use JeroenFrenken\Chat\Core\Router\Exception\MethodNotAllowedException;
use JeroenFrenken\Chat\Core\Router\Exception\RouteNotFoundException;
use JeroenFrenken\Chat\Core\Response\Response;
use JeroenFrenken\Chat\Repository\UserRepository;
use JeroenFrenken\Chat\Core\Router\Router;

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

    public function run()
    {
        $router = new Router($this->_container);
        try {
            $router->handleRequest();
        } catch (RouteNotFoundException $e) {
            new Response('Route not found', Response::NOT_FOUND);
        } catch (MethodNotAllowedException $e) {
            new Response('Method not allowed', Response::METHOD_NOT_ALLOWED);
        }
    }

}
