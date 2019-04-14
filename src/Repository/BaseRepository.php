<?php

namespace JeroenFrenken\Chat\Repository;

use PDO;

/**
 * Configures pdo for in repository usage
 *
 * Class BaseRepository
 * @package JeroenFrenken\Chat\Repository
 */
class BaseRepository
{

    /** @var PDO $pdo */
    protected $pdo;

    /**
     * BaseRepository constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->pdo = new PDO("sqlite:{$config['url']}");
        /*
         * Disable ATTR_EMULATE_PREPARES
         * https://stackoverflow.com/questions/134099/are-pdo-prepared-statements-sufficient-to-prevent-sql-injection
         */
        $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

}
