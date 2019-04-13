<?php

namespace JeroenFrenken\Chat\Middleware;

use DateTime;
use JeroenFrenken\Chat\Core\Middleware\AbstractMiddleware;
use JeroenFrenken\Chat\Core\Response\JsonResponse;
use JeroenFrenken\Chat\Core\Response\Response;
use JeroenFrenken\Chat\Core\Validator\Validator;
use JeroenFrenken\Chat\Entity\User;
use JeroenFrenken\Chat\Interfaces\AuthenticationInterface;
use JeroenFrenken\Chat\Repository\UserRepository;
use JeroenFrenken\Chat\Services\GeneratorService;

class AuthenticationMiddleware extends AbstractMiddleware
{

    public function handle()
    {
        list($controller, $method) = explode('::',$this->container['current_route']['controller'],  2);
        $controller = new $controller();

        if ($controller instanceof AuthenticationInterface) {

            if (!isset(getallheaders()['Authentication'])) {
                return new JsonResponse([
                    [
                        'field' => 'header',
                        'message' => "Missing required authentication header"
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



            var_dump($userRepository->getUserByToken($token));
        }

    }

}
