<?php

namespace JeroenFrenken\Chat\Repository;

use PDO;
use JeroenFrenken\Chat\Entity\Chat;

class ChatRepository extends BaseRepository
{

    public function createChat(Chat $chat): bool
    {
        $sql = "INSERT INTO 
                    chats (owner_id, recipient_id) 
                    VALUES (?, ?)";

        $query = $this->pdo->prepare($sql);
        $res = $query->execute([
            $chat->getOwner()->getId(),
            $chat->getRecipient()->getId()
        ]);

        return $res;
    }

    public function getChatsByUserId(int $userId): array
    {
        $sql = "SELECT 
                    c.id as id,
                    c.owner_id as owner_id,
                    c.recipient_id as recipient_id,
                    owner.username as owner_username,
                    recipient.username as recipient_username
                FROM 
                    chats c
                INNER JOIN users owner on c.owner_id = owner.id
                INNER JOIN users recipient on c.recipient_id = recipient.id
                WHERE c.owner_id = :userId OR c.recipient_id = :userId";

        $query = $this->pdo->prepare($sql);
        $query->bindParam(':userId', $userId);
        $query->execute();

        $data = $query->fetchAll(PDO::FETCH_ASSOC);

        $chats = [];

        foreach ($data as $value) {
            $chat = new Chat();
            $chat->load($value);
            $chats[] = $chat;
        }

        return $chats;
    }

    public function getSingleChatByChatIdAndUserId(int $chatId, int $userId): ?Chat
    {
        $sql = "SELECT 
                    c.id as id,
                    c.owner_id as owner_id,
                    c.recipient_id as recipient_id,
                    owner.username as owner_username,
                    recipient.username as recipient_username
                FROM 
                    chats c
                INNER JOIN users owner on c.owner_id = owner.id
                INNER JOIN users recipient on c.recipient_id = recipient.id
                WHERE 
                      c.id = :chatId AND
                      (c.owner_id = :userId OR
                       c.recipient_id = :userId)";

        $query = $this->pdo->prepare($sql);
        $query->bindParam(':userId', $userId);
        $query->bindParam(':chatId', $chatId);
        $query->execute();

        $data = $query->fetch(PDO::FETCH_ASSOC);

        if (!$data) return null;

        $chat = new Chat();
        $chat->load($data);
        return $chat;
    }

    public function deleteChatByChatIdAndUserId(int $chatId, int $userId): bool
    {
        $sql = "DELETE FROM chats
                WHERE 
                      id = :chatId AND 
                      (owner_id = :userId OR 
                       recipient_id = :userId)";
        $query = $this->pdo->prepare($sql);
        $query->bindParam(':userId', $userId);
        $query->bindParam(':chatId', $chatId);
        $success = $query->execute();

        if (!$success) return false;

        $sql = "DELETE FROM messages
                WHERE chat_id = :chatId";
        $query = $this->pdo->prepare($sql);
        $query->bindParam(':chatId', $chatId);
        $success = $query->execute();

        return $success;
    }

}
