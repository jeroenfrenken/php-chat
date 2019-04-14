<?php

namespace JeroenFrenken\Chat\Controller;

use DateTime;
use Exception;
use JeroenFrenken\Chat\Core\Response\JsonResponse;
use JeroenFrenken\Chat\Core\Validator\Validator;
use JeroenFrenken\Chat\Entity\User;
use JeroenFrenken\Chat\Repository\UserRepository;
use JeroenFrenken\Chat\Response\ApiResponse;
use JeroenFrenken\Chat\Services\GeneratorService;

class UserController extends BaseController
{

    /** @var Validator $_validator */
    private $_validator;

    /** @var UserRepository $_userRepository */
    private $_userRepository;

    /** @var GeneratorService $_generator */
    private $_generator;

    public function __construct()
    {
        parent::__construct();
        $this->_validator = $this->container['service']['validation'];
        $this->_userRepository = $this->container['repository']['user'];
        $this->container = $this->container['service']['generator'];
    }

    public function createUser()
    {
        try {
            $data = $this->handleJsonPostRequest();
        } catch (Exception $exception) {
            return ApiResponse::badRequest('input', 'Json not right formatted');
        }

        $response = $this->_validator->validate('user', $data);

        if (!$response->isStatus()) return ApiResponse::badRequestWithData($response);

        $user = new User();
        $user
            ->setUsername($data['username'])
            ->setPassword($data['password'])
            ->setToken($this->_generator->generateToken())
            ->setTokenCreated(new DateTime());

        $findUser = $this->_userRepository->getUserByUsername($user->getUsername());

        if ($findUser !== null) return ApiResponse::badRequest('username', 'Username already exists');

        $res = $this->_userRepository->createUser($user);

        if ($res) {
            return new JsonResponse([
                'username' => $user->getUsername(),
                'token' => $user->getToken()
            ]);
        } else {
            return ApiResponse::serverError('unknown', 'User creation failed');
        }
    }

    public function authenticateUser()
    {
        try {
            $data = $this->handleJsonPostRequest();
        } catch (Exception $exception) {
            return ApiResponse::badRequest('input', 'Json not right formatted');
        }

        $response = $this->_validator->validate('user', $data);

        if (!$response->isStatus()) return ApiResponse::badRequestWithData($response);

        $user = $this->_userRepository->getUserByUsernameAndPassword($data['username'], $data['password']);

        if ($user === null) return ApiResponse::badRequest('unknown', 'Username or password is not valid');

        $user
            ->setToken($this->_generator->generateToken())
            ->setTokenCreated(new DateTime());

        $status = $this->_userRepository->exchangeNewToken($user);

        if ($status) {
            return new JsonResponse([
                'id' => $user->getId(),
                'username' => $user->getUsername(),
                'token' => $user->getToken()
            ]);
        } else {
            return ApiResponse::serverError('unknown', 'User authentication failed');
        }
    }

}
