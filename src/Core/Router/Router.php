<?php

namespace JeroenFrenken\Chat\Core\Router;

use JeroenFrenken\Chat\Core\Router\Exception\MethodNotAllowedException;
use JeroenFrenken\Chat\Core\Router\Exception\RouteNotFoundException;

/**
 * Class Router
 * @package JeroenFrenken\Chat\Core\Router
 */
class Router
{

    /** @var array $_routes */
    private $_routes;

    /**
     * Router constructor.
     * @param array $routes
     */
    public function __construct(array $routes)
    {
        $this->_routes = $routes;
    }


    /**
     * Finds duplicate routes and returns them as a array
     *
     * @param string $route
     * @return array
     */
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

    /**
     * Checks if a method is allowed for the current route
     * also checks if the route is a duplicate with a other method
     *
     * The duplicate check makes the following possible
     *
     * POST /user
     * GET /user
     *
     * @param array $route
     * @param string $method
     * @return bool|null
     */
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

    /**
     * Parses a url to array and unsets data that is not needed
     *
     * @param string $url
     * @return array
     */
    private function getOptionsFromUrl(string $url): array
    {
        $urlOptions = explode('/', $url);
        foreach ($urlOptions as $key => $value) {
            if (strlen($value) === 0) unset($urlOptions[$key]);
        }
        return $urlOptions;
    }

    /**
     * Matches a route and takes in account that a route can have parameters like /user/:id
     *
     * @param string $url
     * @return array|null
     */
    private function matchRoute(string $url): ?array
    {
        $urlOptions = $this->getOptionsFromUrl($url);
        $urlRequestOptions = $this->getOptionsFromUrl(strtok($_SERVER["REQUEST_URI"],'?'));
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

    /**
     * Starts the router
     *
     * @return array
     * @throws MethodNotAllowedException
     * @throws RouteNotFoundException
     */
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
