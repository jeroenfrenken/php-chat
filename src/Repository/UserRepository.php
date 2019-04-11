<?php
namespace JeroenFrenken\Chat\Repository;

use PDO;
use JeroenFrenken\Chat\Entity\User;

class UserRepository extends BaseRepository
{

    public function createUser(User $user): bool
    {
        $sql = "INSERT INTO 
                    users (username, password, token, token_created) 
                    VALUES (:username, :password, :token, :tokenCreated)";

        $query = $this->pdo->prepare($sql);
        $query->bindParam(':username', $user->getUsername());
        $query->bindParam(':password', $user->getPassword());
        $query->bindParam(':token', $user->getToken());
        $query->bindParam(':tokenCreated', $user->getTokenCreated()->format('Y-m-d H:i:s'));



        return false;
    }

    public function getUserByUsername(string $username): ?User
    {
        $sql = "SELECT * FROM users WHERE username = :username";
        $query = $this->pdo->prepare($sql);
        $query->bindParam(':username', $username);
        $query->execute();

        $data = $query->fetch(PDO::FETCH_ASSOC);

        if (!$data) return null;

        $user = new User();
        $user->load($data);
        return $user;
    }

    public function getUserByUsernameAndPassword(string $username, string $password): ?User
    {
        $user = $this->getUserByUsername($username);

        if (
            $user !== null
            && password_verify($password, $user->getPassword())
        ) {
            return $user;
        }

        return null;
    }

}
