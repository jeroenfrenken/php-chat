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

/**
 * Class Kernel
 * @package JeroenFrenken\Chat
 */
class Kernel
{

    /** @var array $_container */
    private $_container;

    /** @var Response $_response */
    private $_response;

    /**
     * Creates a new Kernel with configuration files
     *
     * Kernel constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->buildContainer($config);
    }

    /**
     * Builds a container. The container is available in all the controllers of the application
     *
     * @param array $config
     */
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

    /**
     * Loads a class and returns the return value of the class.
     * All controllers must return a response
     *
     * @param string $controller
     * @param array $options
     * @return Response|null
     */
    private function loadClassMethod(string $controller, array $options): ?Response
    {
        list($controller, $method) = explode('::', $controller, 2);
        $controller = new $controller();
        return call_user_func_array([$controller, $method], $options);
    }

    /**
     * Loads configured middlewares
     */
    private function loadMiddleware()
    {
        foreach ($this->_container['config']['middleware'] as $middleware) {
            $response = $this->loadClassMethod($middleware['controller'] . '::handle', []);
            if ($response !== null) {
                $this->_response = $response;
            }
        }
    }

    /**
     * Starts the Kernel
     */
    public function run()
    {
        $router = new Router($this->_container['config']['routes']);
        try {
            $route = $router->handle();
        } catch (RouteNotFoundException $e) {
            $this->_response = new Response('Route not found', Response::NOT_FOUND);
        } catch (MethodNotAllowedException $e) {
            $this->_response = new Response('Method not allowed', Response::METHOD_NOT_ALLOWED);
        }

        if ($this->_response === null) {
            $this->_container['current_route'] = $route['route'];
            Container::setContainer($this->_container);
            $this->loadMiddleware();
            if ($this->_response === null) {
                $this->_response = $this->loadClassMethod($route['route']['controller'], $route['params']);
            }
        }

        $this->_response->send();
    }

}
