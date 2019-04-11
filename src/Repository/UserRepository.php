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
        $sql = 'SELECT * FROM users WHERE username = :username AND password = :password';

        $query = $this->pdo->prepare($sql);
        $query->bindParam(':username', $username);
        $query->bindParam(':password', $password);
        $query->execute();

        $data = $query->fetch(PDO::FETCH_ASSOC);

        if ($data === false) return null;

        $user = new User();
        $user->load($data);

        return $user;
    }

}
