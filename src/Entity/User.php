<?php

namespace JeroenFrenken\Chat\Entity;

use DateTime;
use JeroenFrenken\Chat\Interfaces\LoadableEntity;
use JsonSerializable;

class User implements LoadableEntity, JsonSerializable
{

    /** @var int $id */
    protected $id;

    /** @var string $username */
    protected $username;

    /** @var string $password */
    protected $password;

    /** @var string $token */
    protected $token;

    /** @var DateTime $tokenCreated */
    protected $tokenCreated;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return User
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return User
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * @param string $token
     * @return User
     */
    public function setToken(string $token): self
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getTokenCreated(): DateTime
    {
        return $this->tokenCreated;
    }

    /**
     * @param DateTime $tokenCreated
     * @return User
     */
    public function setTokenCreated(DateTime $tokenCreated): self
    {
        $this->tokenCreated = $tokenCreated;
        return $this;
    }

    public function load(array $items)
    {
        $this
            ->setId($items['id'])
            ->setUsername($items['username'])
            ->setPassword($items['password'])
            ->setToken($items['token'])
            ->setTokenCreated(new DateTime($items['token_created']));
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'username' => $this->getUsername()
        ];
    }

}
