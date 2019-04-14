<?php

namespace JeroenFrenken\Chat\Core\Container;

/**
 * A singleton container class
 *
 * Class Container
 * @package JeroenFrenken\Chat\Core\Container
 */
class Container
{

    /** @var array $_container */
    private static $_container;

    public static function getContainer(): array
    {
        if (self::$_container === null) return [];
        return self::$_container;
    }

    public static function setContainer(array $container)
    {
        self::$_container = $container;
    }

}
