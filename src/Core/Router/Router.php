<?php

namespace JeroenFrenken\Chat\Core\Router;

use JeroenFrenken\Chat\Core\Router\Exception\MethodNotAllowedException;
use JeroenFrenken\Chat\Core\Router\Exception\RouteNotFoundException;

class Router
{

    private $_routes;

    public function __construct(array $routes)
    {
        $this->_routes = $routes;
    }

    private function findDuplicateRoutes(string $route): array
    {
        $routes = [];
        $foundRoutes = array_keys(
            array_combine(array_keys($this->_routes), array_column($this->_routes, 'url')),
            $route
        );

        foreach ($foundRoutes as $routeKey) {
            $routes[] = $this->_routes[$routeKey];
        }

        return $routes;
    }

    private function checkMethod(array $route, string $method): ?bool
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

                    if ($matched) return null;
                    return false;
                } else {
                    return false;
                }
            }
        }

        return true;
    }

    private function getOptionsFromUrl(string $url): array
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

        $match = true;
        $requestOptions = [];

        foreach ($urlOptions as $key => $value) {
            if (strpos($value, ':') !== false) {
                $requestOptions[] = $urlRequestOptions[$key];
            } else if ($value !== $urlRequestOptions[$key]) {
                $match = false;
            }
        }

        if ($match) return $requestOptions;
        return null;
    }

    public function handle()
    {
        $routes = $this->_routes;

        foreach ($routes as $route) {
            $match = $this->matchRoute($route['url']);
            if ($match !== null) {
                $matchMethod = $this->checkMethod($route, $_SERVER['REQUEST_METHOD']);
                if ($matchMethod === false) {
                    throw new MethodNotAllowedException();
                } elseif ($matchMethod === null) {
                    continue;
                }
                return [
                    'route' => $route,
                    'params' => $match
                ];
            }
        }

        throw new RouteNotFoundException();
    }

}
