<?php

namespace JeroenFrenken\Chat\Core\Validator;

/**
 * The validate message is used as a response class for the validator
 *
 * Class ValidatorMessage
 * @package JeroenFrenken\Chat\Core\Validator
 */
class ValidatorMessage
{
    /** @var bool $status */
    protected $status;

    /** @var string $message */
    protected $message;

    /**
     * ValidatorMessage constructor.
     *
     * @param bool $status
     * @param string $message
     */
    public function __construct(bool $status, string $message)
    {
        $this->status = $status;
        $this->message = $message;
    }

    /**
     * @return bool
     */
    public function isStatus(): bool
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

}
