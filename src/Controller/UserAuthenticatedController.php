<?php

namespace JeroenFrenken\Chat\Controller;

use JeroenFrenken\Chat\Core\Response\JsonResponse;

class UserAuthenticatedController extends BaseController
{

    public function getUser()
    {
        return new JsonResponse($this->container['user']);
    }


}
