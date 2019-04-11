<?php

namespace JeroenFrenken\Chat\Repository;

use JeroenFrenken\Chat\Entity\Chat;

class ChatRepository extends BaseRepository
{

    public function createChat(Chat $chat): bool
    {
        return false;
    }

    public function getChatsByUserId(int $userId): array
    {
        return [];
    }

    public function getSingleChatByChatIdAndUserId(int $chatId, int $userId): ?Chat
    {
        return new Chat();
    }

    public function deleteChatByChatId(int $chatId): bool
    {
        return false;
    }

}
