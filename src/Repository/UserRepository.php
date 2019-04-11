<?php


namespace JeroenFrenken\Chat\Repository;


use JeroenFrenken\Chat\Entity\User;
use JeroenFrenken\Chat\Services\EntityLoaderService;

class UserRepository extends BaseRepository
{

    public function getAllUsers()
    {
        $sql = "SELECT * FROM users";
        $query = $this->pdo->query($sql);

        $users = [];

        foreach ($query->fetchAll(\PDO::FETCH_ASSOC) as $item) {
            $users[] = EntityLoaderService::loadEntity(User::class, $item);
        }

        return $users;
    }

}
