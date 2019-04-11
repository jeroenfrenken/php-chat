<?php
namespace JeroenFrenken\Chat\Core\Validator;


abstract class BaseValidator
{

    protected abstract function getData(): array;

    public function validate()
    {
        $data = $this->getData();
    }

}
