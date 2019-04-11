<?php
namespace JeroenFrenken\Chat\Controller;


use JeroenFrenken\Chat\Entity\User;
use JeroenFrenken\Chat\Repository\UserRepository;

class ChatController extends BaseController
{

    public function getChats()
    {

        /** @var UserRepository $userRepository */
        $userRepository = $this->container['repository']['user'];


        /** @var User $user */
        foreach ($userRepository->getAllUsers() as $user) {
            var_dump($user->getUsername());
        }
    }

}
