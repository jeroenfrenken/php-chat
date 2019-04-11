<?php
namespace JeroenFrenken\Chat\Entity;

use JsonSerializable;
use JeroenFrenken\Chat\Interfaces\LoadableEntity;

class Chat implements LoadableEntity, JsonSerializable
{

    /** @var int $id */
    protected $id;

    /** @var User $owner */
    protected $owner;

    /** @var User $recipient */
    protected $recipient;

    /** @var Message[] $messages */
    protected $messages;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Chat
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return User
     */
    public function getOwner(): User
    {
        return $this->owner;
    }

    /**
     * @param User $owner
     * @return Chat
     */
    public function setOwner(User $owner): self
    {
        $this->owner = $owner;
        return $this;
    }

    /**
     * @return User
     */
    public function getRecipient(): User
    {
        return $this->recipient;
    }

    /**
     * @param User $recipient
     * @return Chat
     */
    public function setRecipient(User $recipient): self
    {
        $this->recipient = $recipient;
        return $this;
    }

    /**
     * @return Message[]
     */
    public function getMessages(): array
    {
        return $this->messages;
    }

    /**
     * @param Message[] $messages
     * @return Chat
     */
    private function setMessages(array $messages): self
    {
        $this->messages = $messages;
        return $this;
    }

    public function load(array $items)
    {
        $this
            ->setId($items['id'])
            ->setOwner($items['owner'])
            ->setRecipient($items['recipient'])
            ->setMessages($items['messages']);
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'owner' => $this->getOwner(),
            'recipient' => $this->getRecipient(),
            'messages' => $this->getMessages()
        ];
    }

}
