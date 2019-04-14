<?php

namespace JeroenFrenken\Chat\Entity;

use JeroenFrenken\Chat\Interfaces\LoadableEntity;
use JsonSerializable;

class Chat implements LoadableEntity, JsonSerializable
{

    /** @var int $id */
    protected $id;

    /** @var User $owner */
    protected $owner;

    /** @var User $recipient */
    protected $recipient;

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

    public function load(array $items)
    {
        $owner = new User();
        $owner->load([
            'id' => $items['owner_id'],
            'username' => $items['owner_username'],
            'token' => '',
            'token_created' => '0000-00-00 00:00:00'
        ]);

        $recipient = new User();
        $recipient->load([
            'id' => $items['recipient_id'],
            'username' => $items['recipient_username'],
            'token' => '',
            'token_created' => '0000-00-00 00:00:00'
        ]);

        $this
            ->setId($items['id'])
            ->setOwner($owner)
            ->setRecipient($recipient);
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'owner' => $this->getOwner(),
            'recipient' => $this->getRecipient()
        ];
    }

}
