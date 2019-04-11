<?php

namespace JeroenFrenken\Chat\Repository;

use JeroenFrenken\Chat\Entity\Message;

class MessageRepository extends BaseRepository
{

    public function createMessage(Message $message): bool
    {
        return false;
    }

    public function getMessagesByChatIdAndUserId(int $chatId, int $userId): array
    {
        return [];
    }

}
