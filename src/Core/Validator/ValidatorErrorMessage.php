<?php

namespace JeroenFrenken\Chat\Core\Validator;

use JsonSerializable;

/**
 * The validate message is used as a response class for the validator
 *
 * Class ValidatorErrorMessage
 * @package JeroenFrenken\Chat\Core\Validator
 */
class ValidatorErrorMessage implements JsonSerializable
{

    /** @var string $field */
    protected $field;

    /** @var string $message */
    protected $message;

    /**
     * ValidatorErrorMessage constructor.
     *
     * @param string $field
     * @param string $message
     */
    public function __construct(string $field, string $message)
    {
        $this->field = $field;
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }


    public function jsonSerialize()
    {
        return [
            'field' => $this->getField(),
            'message' => $this->getMessage()
        ];
    }

}
