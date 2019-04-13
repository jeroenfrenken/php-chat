<?php

namespace JeroenFrenken\Chat\Core\Container;

trait ContainerAwareTrait
{

    /** @var array $container */
    protected $container;

    public function __construct()
    {
        $this->container = Container::getContainer();
    }

}
