<?php

namespace JeroenFrenken\Chat\Controller;

use DateTime;
use JeroenFrenken\Chat\Core\Response\JsonResponse;
use JeroenFrenken\Chat\Core\Response\Response;
use JeroenFrenken\Chat\Core\Validator\Validator;
use JeroenFrenken\Chat\Entity\User;
use JeroenFrenken\Chat\Repository\UserRepository;
use JeroenFrenken\Chat\Services\GeneratorService;

class UserController extends BaseController
{

    public function getUser()
    {
        var_dump('get user');
    }

    public function createUser()
    {
        try {
            $data = $this->handleJsonPostRequest();
        } catch (\Exception $exception) {
            return new JsonResponse([
                [
                    'field' => 'input',
                    'message' => 'Json not right formatted'
                ]
            ], Response::BAD_REQUEST);
        }

        /** @var Validator $validator */
        $validator = $this->container['service']['validation'];
        $response = $validator->validate('user', $data);

        if (!$response->isStatus()) return new JsonResponse($response);

        /** @var GeneratorService $generator */
        $generator = $this->container['service']['generator'];

        $user = new User();
        $user
            ->setUsername($data['username'])
            ->setPassword($data['password'])
            ->setToken($generator->generateToken())
            ->setTokenCreated(new DateTime());

        /** @var UserRepository $userRepository */
        $userRepository = $this->container['repository']['user'];

        $findUser = $userRepository->getUserByUsername($user->getUsername());

        if ($findUser !== null) {
            return new JsonResponse([
                [
                    'field' => 'username',
                    'message' => 'Username already exists'
                ]
            ], Response::BAD_REQUEST);
        }

        $res = $userRepository->createUser($user);

        if ($res) {
            return new JsonResponse([
                'username' => $user->getUsername(),
                'token' => $user->getToken()
            ]);
        } else {
            return new JsonResponse([
                [
                    'field' => 'unknown',
                    'message' => 'User creation failed'
                ]
            ], Response::BAD_REQUEST);
        }
    }

    public function authenticateUser()
    {
        try {
            $data = $this->handleJsonPostRequest();
        } catch (\Exception $exception) {
            return new JsonResponse([
                [
                'field' => 'input',
                'message' => 'Json not right formatted'
                ]
            ], Response::BAD_REQUEST);
        }

        /** @var Validator $validator */
        $validator = $this->container['service']['validation'];
        $response = $validator->validate('user', $data);

        if (!$response->isStatus()) return new JsonResponse($response);

        /** @var UserRepository $userRepository */
        $userRepository = $this->container['repository']['user'];

        $user = $userRepository->getUserByUsernameAndPassword($data['username'], $data['password']);

        if ($user === null) {
            return new JsonResponse([
                'field' => 'unknown',
                'message' => 'Username or password is not valid'
            ], Response::BAD_REQUEST);
        }

        /** @var GeneratorService $generator */
        $generator = $this->container['service']['generator'];

        $user
            ->setToken($generator->generateToken())
            ->setTokenCreated(new DateTime());

        $status = $userRepository->exchangeNewToken($user);

        if ($status) {
            return new JsonResponse([
                'id' => $user->getId(),
                'username' => $user->getUsername(),
                'token' => $user->getToken()
            ]);
        } else {
            return new JsonResponse([
                [
                    'field' => 'unknown',
                    'message' => 'User authentication failed'
                ]
            ], Response::SERVER_ERROR);
        }
    }

}
