<?php
namespace JeroenFrenken\Chat\Repository;

use PDO;
use JeroenFrenken\Chat\Entity\User;

class UserRepository extends BaseRepository
{

    public function createUser(User $user): bool
    {
        return false;
    }

    public function getUserByUsernameAndPassword(string $username, string $password): ?User
    {
        return new User();
    }

}
