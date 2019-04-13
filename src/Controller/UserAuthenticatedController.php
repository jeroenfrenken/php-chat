<?php

namespace JeroenFrenken\Chat\Controller;

use JeroenFrenken\Chat\Interfaces\AuthenticationInterface;

class UserAuthenticatedController extends BaseController implements AuthenticationInterface
{

    public function getUser()
    {
        var_dump('get user');
    }


}
