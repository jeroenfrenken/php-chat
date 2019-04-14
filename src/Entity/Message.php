<?php

namespace JeroenFrenken\Chat\Entity;

use DateTime;
use JsonSerializable;
use JeroenFrenken\Chat\Interfaces\LoadableEntity;

class Message implements LoadableEntity, JsonSerializable
{

    /** @var int $id */
    protected $id;

    /** @var Chat $chat */
    protected $chat;

    /** @var User $user */
    protected $user;

    /** @var string $message */
    protected $message;

    /** @var DateTime $created */
    protected $created;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Message
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Chat
     */
    public function getChat(): Chat
    {
        return $this->chat;
    }

    /**
     * @param Chat $chat
     * @return Message
     */
    public function setChat(Chat $chat): self
    {
        $this->chat = $chat;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return Message
     */
    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return Message
     */
    public function setMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreated(): DateTime
    {
        return $this->created;
    }

    /**
     * @param DateTime $created
     * @return Message
     */
    public function setCreated(DateTime $created): self
    {
        $this->created = $created;
        return $this;
    }

    public function load(array $items)
    {
        $user = new User();
        $user->setId($items['user_id']);
        $user->setUsername($items['user_username']);

        $chat = new Chat();
        $chat->setId($items['chat_id']);

        $this
            ->setId($items['id'])
            ->setChat($chat)
            ->setUser($user)
            ->setMessage($items['message'])
            ->setCreated(new DateTime($items['created']));
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'user' => $this->getUser(),
            'message' => $this->getMessage(),
            'created' => $this->getCreated()
        ];
    }

}
