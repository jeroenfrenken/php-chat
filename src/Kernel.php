<?php
namespace JeroenFrenken\Chat;

use JeroenFrenken\Chat\Event\Request;

class Kernel
{

    private $_container;

    public function __construct()
    {
        $this->buildContainer();
    }

    private function buildContainer()
    {
        $this->_container = [];
        $this->_container['config']['routes'] = require_once __DIR__ . '/../config/Routes.php';
        $this->_container['config']['database'] = require_once __DIR__ . '/../config/Database.php';
    }

    public function run()
    {
        $request = new Request($this->_container);
        $request->handle();
    }

}
