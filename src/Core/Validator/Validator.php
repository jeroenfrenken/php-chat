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
    private function validateItem(array $rules, string $input): ValidatorMessage
    {
        if(isset($rules['regex'])) {
            if(!preg_match($rules['regex'], $input)) {
                return new ValidatorMessage(false, $rules['message']);
            }
        } else {
            if(isset($rules['function'])) {
                if(!$rules['function']($input)) {
                    return new ValidatorMessage(false, $rules['message']);
                }
            }
        }

        return new ValidatorMessage(true, "");
    }

    public function validate(string $key, array $validateData): ValidatorMessage
    {
        if (!isset($this->_config[$key])) {
            return new ValidatorMessage(false, "Key not found");
        } else {
            $data = $this->_config[$key];
        }

        foreach ($validateData as $field => $input) {
            if (!isset($data[$field])) {
                return new ValidatorMessage(false, "Field {$field} is not configured");
            }
            $validate = $this->validateItem($data[$field], $input);
            if (!$validate->isStatus()) {
                return $validate;
            }
        }

        return new ValidatorMessage(true, "Validation success");
    }

}
