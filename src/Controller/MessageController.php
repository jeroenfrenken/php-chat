<?php

namespace JeroenFrenken\Chat\Controller;

use JeroenFrenken\Chat\Entity\User;

class MessageController extends BaseController
{

    public function createMessage(string $id)
    {
        /** @var User $user */
        $user = $this->container['user'];
    }

    public function getMessages(string $id)
    {
        /** @var User $user */
        $user = $this->container['user'];
    }

}
