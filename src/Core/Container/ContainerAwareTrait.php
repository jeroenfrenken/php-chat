<?php

namespace JeroenFrenken\Chat\Core\Container;

/**
 * A trait that loads the container
 *
 * Trait ContainerAwareTrait
 * @package JeroenFrenken\Chat\Core\Container
 */
trait ContainerAwareTrait
{

    /** @var array $container */
    protected $container;

    public function __construct()
    {
        $this->container = Container::getContainer();
    }

}
