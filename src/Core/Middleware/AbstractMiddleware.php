<?php

namespace JeroenFrenken\Chat\Core\Middleware;

use JeroenFrenken\Chat\Core\Container\ContainerAwareTrait;

/**
 * Middleware helper that makes the container available and forces the handle method to be used
 *
 * Class AbstractMiddleware
 * @package JeroenFrenken\Chat\Core\Middleware
 */
abstract class AbstractMiddleware
{

    use ContainerAwareTrait;

    abstract public function handle();

}
