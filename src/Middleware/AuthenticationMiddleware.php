<?php

namespace JeroenFrenken\Chat\Middleware;

use JeroenFrenken\Chat\Core\Container\Container;
use JeroenFrenken\Chat\Core\Middleware\AbstractMiddleware;
use JeroenFrenken\Chat\Core\Response\JsonResponse;
use JeroenFrenken\Chat\Core\Response\Response;
use JeroenFrenken\Chat\Core\Validator\Validator;
use JeroenFrenken\Chat\Repository\UserRepository;
use JeroenFrenken\Chat\Response\ApiResponse;

/**
 * Checks the api key and sets the user in the container
 *
 * Class AuthenticationMiddleware
 * @package JeroenFrenken\Chat\Middleware
 */
class AuthenticationMiddleware extends AbstractMiddleware
{

    public function handle()
    {
        if ($this->container['current_route']['auth']) {

            if (!isset(getallheaders()['Authentication'])) {
                return ApiResponse::badRequest('header', 'Missing required authentication header');
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

            if ($user === null) return ApiResponse::notAuthorized('token', 'Token is not valid');

            $this->container['user'] = $user;
            Container::setContainer($this->container);
        }
    }

}
