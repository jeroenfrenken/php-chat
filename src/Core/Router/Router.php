<?php
namespace JeroenFrenken\Chat\Core\Router;

use JeroenFrenken\Chat\Core\Router\Exception\RouteNotFoundException;
use JeroenFrenken\Chat\Core\Router\Exception\MethodNotAllowedException;

class Router
{

    private $_routes;
    private $_container;

    public function __construct(array $container)
    {
        $this->_container = $container;
        $this->_routes = $container['config']['routes'];
    }

    private function findDuplicateRoutes(string $route): array
    {
        $foundRoutes = array_keys(
            array_combine(array_keys($this->_routes), array_column($this->_routes, 'url')),
            $route
        );

        $routes = [];

        foreach ($foundRoutes as $routeKey) {
            $routes[] = $this->_routes[$routeKey];
        }

        return $routes;
    }

    private function checkMethod(array $route, string $method): bool
    {
        if (isset($route['methods'])) {
            if (!in_array($method, $route['methods'])) {
                $duplicateRoutes = $this->findDuplicateRoutes($route['url']);
                if (count($duplicateRoutes) > 1) {
                    $matched = false;

                    foreach ($duplicateRoutes as $route) {
                        if (in_array($method, $route['methods'])) {
                            $matched = true;
                            break;
                        }
                    }

                    if (!$matched) {
                        return false;
                    }
                } else {
                    return false;
                }
            }
        }

        return true;
    }

    private function loadController(string $controller, array $options = [])
    {
        list($controller, $method) = explode('::', $controller, 2);
        $controller = new $controller($this->_container);
        call_user_func_array([$controller, $method], $options);
    }

    private function getOptionsFromUrl(string $url) : array
    {
        $urlOptions = explode('/', $url);
        foreach ($urlOptions as $key => $value) {
            if (strlen($value) === 0) unset($urlOptions[$key]);
        }
        return $urlOptions;
    }

    private function matchRoute(string $url): ?array
    {
        $urlOptions = $this->getOptionsFromUrl($url);
        $urlRequestOptions = $this->getOptionsFromUrl($_SERVER['REQUEST_URI']);
        if (count($urlOptions) !== count($urlRequestOptions)) return null;

        $requestOptions = [];
        $match = true;

        foreach ($urlOptions as $key => $value) {
            if (strpos($value, ':') !== false) {
                $requestOptions[] = $urlRequestOptions[$key];
            } else if ($value !== $urlRequestOptions[$key]) {
                $match = false;
            }
        }

        if ($match) {
            return $requestOptions;
        }

        return null;
    }

    public function handleRequest()
    {
        $routes = $this->_routes;

        foreach ($routes as $route) {
            $match = $this->matchRoute($route['url']);
            if ($match !== null) {

                if (!$this->checkMethod($route, $_SERVER['REQUEST_METHOD'])) {
                    throw new MethodNotAllowedException();
                }
                $this->loadController($route['controller'], $match);
                return;
            }
        }

        throw new RouteNotFoundException();
    }

}
