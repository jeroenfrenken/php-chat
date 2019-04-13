<?php

namespace JeroenFrenken\Chat\Repository;

use JeroenFrenken\Chat\Entity\User;
use PDO;

class UserRepository extends BaseRepository
{

    public function createUser(User $user): bool
    {
        $sql = "INSERT INTO 
                    users (username, password, token, token_created) 
                    VALUES (?, ?, ?, ?)";

        $query = $this->pdo->prepare($sql);
        $res = $query->execute([
            $user->getUsername(),
            password_hash($user->getPassword(), PASSWORD_BCRYPT),
            $user->getToken(),
            $user->getTokenCreated()->format('Y-m-d H:i:s')
        ]);

        return $res;
    }

    public function exchangeNewToken(User $user): bool
    {
        $sql = "UPDATE users SET token = ?, token_created = ? WHERE username = ?";

        $query = $this->pdo->prepare($sql);
        $res = $query->execute([
            $user->getToken(),
            $user->getTokenCreated()->format('Y-m-d H:i:s'),
            $user->getUsername()
        ]);

        return $res;
    }

    public function getUserByToken(string $token): ?User
    {
        $sql = "SELECT * FROM users WHERE token = :token";
        $query = $this->pdo->prepare($sql);
        $query->bindParam(':token', $token);
        $query->execute();

        $data = $query->fetch(PDO::FETCH_ASSOC);
        if (!$data) return null;

        $user = new User();
        $user->load($data);
        return $user;
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
        if ($user !== null && password_verify($password, $user->getPassword())) return $user;
        return null;
    }

}
