<?php

namespace JeroenFrenken\Chat\Core\Validator;
/**
 * Class Validator
 * @package JeroenFrenken\Chat\Core\Validator
 */
class Validator
{
    /** @var array $_config */
    private $_config;

    /**
     * Validator constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->_config = $config;
    }

    /**
     * @param array $rules
     * @param string $field
     * @param string $input
     * @return ValidatorErrorMessage|null
     */
    private function validateItem(array $rules, string $field, string $input): ?ValidatorErrorMessage
    {
        if(isset($rules['regex'])) {
            if(!preg_match($rules['regex'], $input)) {
                return new ValidatorErrorMessage($field, $rules['message']);
            }
        } else {
            if(isset($rules['function'])) {
                if(!$rules['function']($input)) {
                    return new ValidatorErrorMessage($field, $rules['message']);
                }
            }
        }

        return null;
    }

    /**
     * Checks if all required fields
     *
     * @param array $data
     * @param array $input
     * @return array
     */
    private function checkRequiredFieldsMet(array $data, array $input): array
    {
        $missingFields = [];

        foreach ($data as $field => $value) {
            if ($value['required']) {
                if (!isset($input[$field])) {
                    $missingFields[] = new ValidatorErrorMessage($field, "Field {$field} is required");
                }
            }
        }

        return $missingFields;
    }

    /**
     * @param string $key
     * @param array $validateData
     * @return ValidatorResponse
     */
    public function validate(string $key, array $validateData): ValidatorResponse
    {
        if (!isset($this->_config[$key])) {
            return new ValidatorResponse(false, []);
        } else {
            $data = $this->_config[$key];
        }

        $messages = [];

        $requiredFields = $this->checkRequiredFieldsMet($data, $validateData);

        if (!empty($requiredFields)) {
            return new ValidatorResponse(false, $requiredFields);
        }

        foreach ($validateData as $field => $input) {
            if (!isset($data[$field])) {
                $messages[] = new ValidatorErrorMessage($field, "Field {$field} is not configured");
                continue;
            }
            $validate = $this->validateItem($data[$field],$field, $input);
            if ($validate !== null) {
                $messages[] = $validate;
            }
        }

        return new ValidatorResponse(count($messages) === 0, $messages);
    }

}
