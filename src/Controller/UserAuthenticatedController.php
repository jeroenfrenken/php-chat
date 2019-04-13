<?php

namespace JeroenFrenken\Chat\Controller;

use JeroenFrenken\Chat\Core\Response\JsonResponse;
use JeroenFrenken\Chat\Entity\User;

class UserAuthenticatedController extends BaseController
{

    public function getUser()
    {
        /** @var User $user */
        $user = $this->container['user'];
        return new JsonResponse($user);
    }


}
