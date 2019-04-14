<?php

namespace JeroenFrenken\Chat\Repository;

use PDO;
use DateTime;
use JeroenFrenken\Chat\Entity\Message;

class MessageRepository extends BaseRepository
{

    public function createMessage(Message $message): bool
    {
        $sql = "INSERT INTO 
                    messages (chat_id, user_id, message, created) 
                    VALUES (?, ?, ?, ?)";

        $query = $this->pdo->prepare($sql);
        $res = $query->execute([
            $message->getChat()->getId(),
            $message->getUser()->getId(),
            $message->getMessage(),
            $message->getCreated()->format('Y-m-d H:i:s')
        ]);

        return $res;
    }

    public function getMessagesByChatIdAndUserId(int $chatId, int $userId): array
    {
        $sql = "SELECT 
                    m.*,
                    c.id as chat_id,
                    c.owner_id as chat_owner_id,
                    c.recipient_id as chat_recipient_id,
                    u.username as user_username
                FROM 
                    messages m
                INNER JOIN chats c on c.id = m.chat_id
                INNER JOIN users u on m.user_id = u.id
                WHERE
                      m.chat_id = :chatId AND
                      (c.owner_id = :userId OR 
                       c.recipient_id = :userId)
                ORDER BY m.created DESC";

        $query = $this->pdo->prepare($sql);
        $query->bindParam(':chatId', $chatId);
        $query->bindParam(':userId', $userId);
        $query->execute();

        $data = $query->fetchAll(PDO::FETCH_ASSOC);

        $messages = [];

        foreach ($data as $value) {
            $chat = new Message();
            $chat->load($value);
            $messages[] = $chat;
        }

        return $messages;
    }

    public function getMessagesByChatIdAndUserIdAndTime(int $chatId, int $userId, DateTime $dateTime)
    {
        $sql = "SELECT 
                    m.*,
                    c.id as chat_id,
                    c.owner_id as chat_owner_id,
                    c.recipient_id as chat_recipient_id,
                    u.username as user_username
                FROM 
                    messages m
                INNER JOIN chats c on c.id = m.chat_id
                INNER JOIN users u on m.user_id = u.id
                WHERE 
                      m.created >= :time AND
                      m.chat_id = :chatId AND
                      (c.owner_id = :userId OR 
                       c.recipient_id = :userId)
                ORDER BY m.created DESC";

        $query = $this->pdo->prepare($sql);
        $time = $dateTime->format('Y-m-d H:i:s');
        $query->bindParam(':chatId', $chatId);
        $query->bindParam(':userId', $userId);
        $query->bindParam(':time', $time);
        $query->execute();

        $data = $query->fetchAll(PDO::FETCH_ASSOC);

        $messages = [];

        foreach ($data as $value) {
            $chat = new Message();
            $chat->load($value);
            $messages[] = $chat;
        }

        return $messages;
    }

}
