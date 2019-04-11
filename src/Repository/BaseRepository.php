<?php


namespace JeroenFrenken\Chat\Repository;


class BaseRepository
{

    protected $pdo;

    public function __construct(array $config)
    {
        $this->pdo = new \PDO("sqlite:{$config['url']}");
    }

}
