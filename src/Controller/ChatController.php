<?php
namespace JeroenFrenken\Chat\Controller;


use JeroenFrenken\Chat\Entity\User;
use JeroenFrenken\Chat\Repository\UserRepository;

class ChatController
{

    public function getChats(array $container)
    {

        /** @var UserRepository $userRepository */
        $userRepository = $container['repository']['user'];


        /** @var User $user */
        foreach ($userRepository->getAllUsers() as $user) {
            var_dump($user->getUsername());
        }
    }

}
