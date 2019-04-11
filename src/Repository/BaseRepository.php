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
        $this->pdo->query('SET NAMES utf8');
        $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

}
