<?php


namespace JeroenFrenken\Chat\Repository;


use JeroenFrenken\Chat\Entity\User;
use JeroenFrenken\Chat\Services\EntityLoaderService;

class UserRepository extends BaseRepository
{

    public function getAllUsers(): array
    {
        $sql = "SELECT * FROM users";
        $query = $this->pdo->query($sql);
        $users = [];

        foreach ($query->fetchAll(\PDO::FETCH_ASSOC) as $item) {
            $user = new User();
            $user->load($item);
            $users[] = $user;
        }

        return $users;
    }

}
