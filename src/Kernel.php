<?php

namespace JeroenFrenken\Chat;

use JeroenFrenken\Chat\Core\Container\Container;
use JeroenFrenken\Chat\Core\Response\Response;
use JeroenFrenken\Chat\Core\Router\Exception\MethodNotAllowedException;
use JeroenFrenken\Chat\Core\Router\Exception\RouteNotFoundException;
use JeroenFrenken\Chat\Core\Router\Router;
use JeroenFrenken\Chat\Core\Validator\Validator;
use JeroenFrenken\Chat\Repository\ChatRepository;
use JeroenFrenken\Chat\Repository\MessageRepository;
use JeroenFrenken\Chat\Repository\UserRepository;
use JeroenFrenken\Chat\Services\GeneratorService;

class Kernel
{

    private $_container;

    public function __construct(array $config)
    {
        $this->buildContainer($config);
    }

    private function buildContainer(array $config)
    {
        $container = [];
        $container['config'] = $config;
        $container['repository']['user'] = new UserRepository($config['database']);
        $container['repository']['chat'] = new ChatRepository($config['database']);
        $container['repository']['message'] = new MessageRepository($config['database']);
        $container['service']['validation'] = new Validator($config['validation']);
        $container['service']['generator'] = new GeneratorService();
        Container::setContainer($container);
        $this->_container = $container;
    }

    public function run()
    {
        $router = new Router($this->_container['config']['routes']);
        try {
            $router->handleRequest();
        } catch (RouteNotFoundException $e) {
            new Response('Route not found', Response::NOT_FOUND);
        } catch (MethodNotAllowedException $e) {
            new Response('Method not allowed', Response::METHOD_NOT_ALLOWED);
        }
    }

}
