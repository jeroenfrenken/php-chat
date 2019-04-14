<?php

namespace JeroenFrenken\Chat\Interfaces;

/**
 * A loadable entity is a entity that is able to be configured with the load method
 * used in the Repositories
 *
 * Interface LoadableEntity
 * @package JeroenFrenken\Chat\Interfaces
 */
interface LoadableEntity
{

    public function load(array $items);

}
