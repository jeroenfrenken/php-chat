<?php

namespace JeroenFrenken\Chat\Core\Middleware;


use JeroenFrenken\Chat\Core\Container\ContainerAwareTrait;

abstract class AbstractMiddleware
{

    use ContainerAwareTrait;

    abstract public function handle();

}
