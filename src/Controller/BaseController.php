<?php

namespace JeroenFrenken\Chat\Controller;

class BaseController
{

    /** @var array $container */
    protected $container;

    public function __construct(array $container)
    {
        $this->container = $container;
    }

}
