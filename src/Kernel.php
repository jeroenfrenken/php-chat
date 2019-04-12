<?php

namespace JeroenFrenken\Chat;

use JeroenFrenken\Chat\Core\Response\Response;
use JeroenFrenken\Chat\Core\Router\Exception\MethodNotAllowedException;
use JeroenFrenken\Chat\Core\Router\Exception\RouteNotFoundException;
use JeroenFrenken\Chat\Core\Router\Router;
use JeroenFrenken\Chat\Core\Validator\Validator;
use JeroenFrenken\Chat\Repository\ChatRepository;
use JeroenFrenken\Chat\Repository\MessageRepository;
use JeroenFrenken\Chat\Repository\UserRepository;

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
        $this->_container['repository']['chat'] = new ChatRepository($config['database']);
        $this->_container['repository']['message'] = new MessageRepository($config['database']);
        $this->_container['service']['validation'] = new Validator($config['validation']);
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
