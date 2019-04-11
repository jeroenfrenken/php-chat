<?php
namespace JeroenFrenken\Chat\Core\Validator;


class UserValidator extends BaseValidator
{

    protected function getData(): array
    {
        return [
            'username' => [
                'regex' => "",
                'message' => "Username not valid"
            ],
            'password' => [
                'regex' => "",
                'message' => "Password not valid"
            ]
        ];
    }

}
