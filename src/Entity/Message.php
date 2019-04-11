<?php
namespace JeroenFrenken\Chat\Entity;

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


    public function load(array $items)
    {
        $this
            ->setId($items['id'])
            ->setChat($items['chat'])
            ->setUser($items['user'])
            ->setMessage($items['message']);
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'user' => $this->getUser(),
            'message' => $this->getMessage()
        ];
    }

}
