<?php

namespace JeroenFrenken\Chat\Controller;

use Exception;
use JeroenFrenken\Chat\Core\Response\JsonResponse;
use JeroenFrenken\Chat\Core\Validator\Validator;
use JeroenFrenken\Chat\Entity\Chat;
use JeroenFrenken\Chat\Entity\User;
use JeroenFrenken\Chat\Repository\ChatRepository;
use JeroenFrenken\Chat\Repository\UserRepository;
use JeroenFrenken\Chat\Response\ApiResponse;

class ChatController extends BaseController
{

    /** @var User $_user */
    private $_user;

    /** @var UserRepository $_chatRepository */
    private $_userRepository;

    /** @var ChatRepository $_chatRepository */
    private $_chatRepository;

    /** @var Validator $_validator */
    private $_validator;

    public function __construct()
    {
        parent::__construct();
        $this->_user = $this->container['user'];
        $this->_userRepository = $this->container['repository']['user'];
        $this->_chatRepository = $this->container['repository']['chat'];
        $this->_validator = $this->container['service']['validation'];
    }

    public function getChat(string $id)
    {
        $chat = $this->_chatRepository->getSingleChatByChatIdAndUserId(intval($id), $this->_user->getId());
        if ($chat === null) {
            return ApiResponse::notFound('id', 'Chat not found');
        }
        return new JsonResponse($chat);
    }

    public function getChats()
    {
        return new JsonResponse($this->_chatRepository->getChatsByUserId($this->_user->getId()));
    }

    public function createChat()
    {
        try {
            $data = $this->handleJsonPostRequest();
        } catch (Exception $exception) {
            return ApiResponse::badRequest('input', 'Json not right formatted');
        }

        $response = $this->_validator->validate('chat', $data);

        if (!$response->isStatus()) return ApiResponse::badRequestWithData($response->getMessages());

        $recipient = $this->_userRepository->getUserByUsername($data['recipient']);

        if ($recipient === null) {
            return ApiResponse::notFound('recipient', 'Recipient not found');
        }

        if ($this->_user->getId() === $recipient->getId()) {
            return ApiResponse::badRequest('recipient', 'Recipient can not be same as owner');
        }

        $chat = new Chat();
        $chat->setOwner($this->_user);
        $chat->setRecipient($recipient);

        $success = $this->_chatRepository->createChat($chat);

        if ($success) {
            return new JsonResponse([]);
        } else {
            return ApiResponse::serverError('unknown', 'Chat creation failed');
        }
    }

    public function deleteChat(string $id)
    {

        $success = $this->_chatRepository->deleteChatByChatIdAndUserId(intval($id), $this->_user->getId());

        if ($success) {
            return new JsonResponse([]);
        } else {
            return ApiResponse::serverError('unknown', 'Chat could not be deleted');
        }
    }

}
