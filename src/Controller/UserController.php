<?php
namespace JeroenFrenken\Chat\Controller;

use JeroenFrenken\Chat\Repository\UserRepository;

class UserController extends BaseController
{

    public function getUser()
    {

    }

    public function createUser()
    {

    }

    public function authenticateUser()
    {
        /** @var UserRepository $userRepository */
        $userRepository = $this->container['repository']['user'];

        $user = $userRepository->getUserByUsernameAndPassword('jeroenfrenfken', 'Jeroen12');

        var_dump($user); exit;
    }

}
