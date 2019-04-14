<?php

namespace JeroenFrenken\Chat\Controller;

use DateTime;
use Exception;
use JeroenFrenken\Chat\Core\Response\Response;
use JeroenFrenken\Chat\Entity\Chat;
use JeroenFrenken\Chat\Entity\Message;
use JeroenFrenken\Chat\Entity\User;
use JeroenFrenken\Chat\Core\Validator\Validator;
use JeroenFrenken\Chat\Core\Response\JsonResponse;
use JeroenFrenken\Chat\Repository\MessageRepository;

class MessageController extends BaseController
{

    /** @var User $_user */
    private $_user;

    /** @var Validator $_validator */
    private $_validator;

    /** @var MessageRepository $_messageRepository */
    private $_messageRepository;

    public function __construct()
    {
        parent::__construct();
        $this->_user = $this->container['user'];
        $this->_messageRepository = $this->container['repository']['message'];
        $this->_validator = $this->container['service']['validation'];
    }

    public function createMessage(string $id)
    {
        try {
            $data = $this->handleJsonPostRequest();
        } catch (Exception $e) {
            return new JsonResponse([
                [
                    'field' => 'input',
                    'message' => 'Json not right formatted'
                ]
            ], Response::BAD_REQUEST);
        }

        $response = $this->_validator->validate('message', $data);

        if (!$response->isStatus()) return new JsonResponse($response, Response::BAD_REQUEST);

        $chat = new Chat();
        $chat->setId(intval($id));

        $message = new Message();
        $message
            ->setCreated(new DateTime())
            ->setMessage($data['message'])
            ->setChat($chat)
            ->setUser($this->_user);

        $success = $this->_messageRepository->createMessage($message);

        if ($success) {
            return new JsonResponse([]);
        } else {
            return new JsonResponse([
                [
                    'field' => 'unknown',
                    'message' => 'Message creation failed'
                ]
            ], Response::SERVER_ERROR);
        }
    }

    public function getMessages(string $id)
    {
        return new JsonResponse(
            $this->_messageRepository->getMessagesByChatIdAndUserId(intval($id), $this->_user->getId())
        );
    }

}
