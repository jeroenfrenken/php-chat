<?php


namespace JeroenFrenken\Chat\Controller;


class BaseController
{

    protected $container;


    public function __construct(array $container)
    {
        $this->container = $container;
    }

}
