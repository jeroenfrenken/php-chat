<?php
namespace JeroenFrenken\Chat\Repository;

use PDO;

class BaseRepository
{
    /** @var PDO $pdo */
    protected $pdo;

    public function __construct(array $config)
    {
        $this->pdo = new PDO("sqlite:{$config['url']}");
        /*
         * Set Charset to utf8
         */
        $this->pdo->query('SET NAMES utf8');
        /*
         * Disable ATTR_EMULATE_PREPARES
         * https://stackoverflow.com/questions/134099/are-pdo-prepared-statements-sufficient-to-prevent-sql-injection
         */
        $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

}
