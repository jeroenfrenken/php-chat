<?php

namespace JeroenFrenken\Chat\Controller;

use JeroenFrenken\Chat\Core\Validator\Validator;
use JeroenFrenken\Chat\Repository\UserRepository;

class UserController extends BaseController
{

    public function getUser()
    {
        var_dump('get user');
    }

    public function createUser()
    {
        $data = file_get_contents('php://input');

        /** @var Validator $validator */
        $validator = $this->container['service']['validation'];

        var_dump($validator->validate('user', [
            'username' => 'Jeroen',
            'password' => 'Password'
        ]));

        var_dump($data);
        exit;
    }

    public function authenticateUser()
    {
        /** @var UserRepository $userRepository */
        $userRepository = $this->container['repository']['user'];

        $user = $userRepository->getUserByUsernameAndPassword('jeroenfrenken', 'Jeroen12');

        var_dump($user);
        exit;
    }

}
