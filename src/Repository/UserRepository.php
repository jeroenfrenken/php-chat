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

    public function getUserByUsernameAndPassword(string $username, string $password): ?User
    {
        $sql = "SELECT * FROM users WHERE username = :username";

        $query = $this->pdo->prepare($sql);
        $query->bindParam(':username', $username);
        $query->execute();

        $data = $query->fetch(PDO::FETCH_ASSOC);

        if (
            !$data
            || !password_verify($password, $data["password"])
        ) {
            return null;
        }

        $user = new User();
        $user->load($data);
        return $user;
    }

}
