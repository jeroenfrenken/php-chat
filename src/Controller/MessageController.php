<?php

namespace JeroenFrenken\Chat\Controller;

use DateTime;
use Exception;
use JeroenFrenken\Chat\Entity\Message;
use JeroenFrenken\Chat\Entity\User;
use JeroenFrenken\Chat\Core\Validator\Validator;
use JeroenFrenken\Chat\Core\Response\JsonResponse;
use JeroenFrenken\Chat\Repository\ChatRepository;
use JeroenFrenken\Chat\Repository\MessageRepository;
use JeroenFrenken\Chat\Response\ApiResponse;

class MessageController extends BaseController
{

    /** @var User $_user */
    private $_user;

    /** @var Validator $_validator */
    private $_validator;

    /** @var MessageRepository $_messageRepository */
    private $_messageRepository;

    /** @var ChatRepository $_chatRepository */
    private $_chatRepository;

    public function __construct()
    {
        parent::__construct();
        $this->_user = $this->container['user'];
        $this->_messageRepository = $this->container['repository']['message'];
        $this->_chatRepository = $this->container['repository']['chat'];
        $this->_validator = $this->container['service']['validation'];
    }

    public function createMessage(string $id)
    {
        try {
            $data = $this->handleJsonPostRequest();
        } catch (Exception $e) {
            return ApiResponse::badRequest('input', 'Json not right formatted');
        }

        $response = $this->_validator->validate('message', $data);

        if (!$response->isStatus()) return ApiResponse::badRequestWithData($response);

        $chat = $this->_chatRepository->getSingleChatByChatIdAndUserId(intval($id), $this->_user->getId());

        if ($chat === null) return ApiResponse::notFound('id', 'Chat not found');

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
            return ApiResponse::serverError('unknown', 'Message creation failed');
        }
    }

    public function getMessages(string $id)
    {
        $chat = $this->_chatRepository->getSingleChatByChatIdAndUserId(intval($id), $this->_user->getId());
        if ($chat === null) return ApiResponse::notFound('id', 'Chat not found');

        return new JsonResponse(
            $this->_messageRepository->getMessagesByChatIdAndUserId(intval($id), $this->_user->getId())
        );
    }

}
