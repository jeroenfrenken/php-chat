<?php

namespace JeroenFrenken\Chat\Middleware;

use JeroenFrenken\Chat\Core\Container\Container;
use JeroenFrenken\Chat\Core\Middleware\AbstractMiddleware;
use JeroenFrenken\Chat\Core\Response\JsonResponse;
use JeroenFrenken\Chat\Core\Response\Response;
use JeroenFrenken\Chat\Core\Validator\Validator;
use JeroenFrenken\Chat\Repository\UserRepository;

class AuthenticationMiddleware extends AbstractMiddleware
{

    public function handle()
    {
        if ($this->container['current_route']['auth']) {

            if (!isset(getallheaders()['Authentication'])) {
                return new JsonResponse([
                    [
                        'field' => 'header',
                        'message' => 'Missing required authentication header'
                    ]
                ], Response::BAD_REQUEST);
            }

            $token = getallheaders()['Authentication'];

            /** @var Validator $validator */
            $validator = $this->container['service']['validation'];
            $response = $validator->validate('token', [
                'token' => $token
            ]);

            if (!$response->isStatus()) return new JsonResponse($response);

            /** @var UserRepository $userRepository */
            $userRepository = $this->container['repository']['user'];

            $user = $userRepository->getUserByToken($token);

            if ($user === null) {
                return new JsonResponse([
                    [
                        'field' => 'token',
                        'message' => 'Token is not valid'
                    ]
                ], Response::BAD_REQUEST);
            }

            $this->container['user'] = $user;
            Container::setContainer($this->container);
        }

    }

}
