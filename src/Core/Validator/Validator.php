<?php

namespace JeroenFrenken\Chat\Core\Validator;

class Validator
{

    private $_config;

    public function __construct(array $config)
    {
        $this->_config = $config;
    }

    /**
     *
     * Validates a input based on the rules
     * A rules array contains a regex or a function with a message
     *
     * The function checks if the rules are correct with the user input and returns the right message
     *
     * @param array $rules
     * @param string $field
     * @return ValidatorMessage
     */
    private function validateItem(array $rules, string $field): ValidatorMessage
    {
        if(isset($rules['regex'])) {
            if(!preg_match($rules['regex'], $field)) {
                return new ValidatorMessage(false, $rules['message']);
            }
        } else {
            if(isset($rules['function'])) {
                if(!$rules['function']($field)) {
                    return new ValidatorMessage(false, $rules['message']);
                }
            }
        }

        return new ValidatorMessage(true, "");
    }

    public function validate(string $domain, array $input): ValidatorMessage
    {
        if (!isset($this->_config[$domain])) {
            return new ValidatorMessage(false, "Domain not found");
        } else {
            $data = $this->_config[$domain];
        }

        foreach ($input as $key => $value) {
            if (!isset($data[$key])) {
                return new ValidatorMessage(false, "Key not supported");
            }
            $validate = $this->validateItem($data[$key], $value);
            if (!$validate->isStatus()) {
                return $validate;
            }
        }

        return new ValidatorMessage(true, "Validation success");
    }

}
