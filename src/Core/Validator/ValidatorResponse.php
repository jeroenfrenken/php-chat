<?php

namespace JeroenFrenken\Chat\Core\Validator;

use JsonSerializable;

/**
 * Holds the array of messages and a general status code
 *
 * Class ValidatorResponse
 * @package JeroenFrenken\Chat\Core\Validator
 */
class ValidatorResponse implements JsonSerializable
{

    /** @var bool $status */
    protected $status;

    /** @var ValidatorErrorMessage[] $messages */
    protected $messages;

    public function __construct(bool $status, array $messages)
    {
        $this->status = $status;
        $this->messages = $messages;
    }

    /**
     * @return bool
     */
    public function isStatus(): bool
    {
        return $this->status;
    }

    /**
     * @return ValidatorErrorMessage[]
     */
    public function getMessages(): array
    {
        return $this->messages;
    }

    public function jsonSerialize()
    {
        return $this->getMessages();
    }

}
