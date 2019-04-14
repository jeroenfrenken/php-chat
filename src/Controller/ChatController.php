<?php

namespace JeroenFrenken\Chat\Controller;

use JeroenFrenken\Chat\Core\Response\JsonResponse;
use JeroenFrenken\Chat\Core\Response\Response;
use JeroenFrenken\Chat\Core\Validator\Validator;
use JeroenFrenken\Chat\Entity\Chat;
use JeroenFrenken\Chat\Entity\User;
use JeroenFrenken\Chat\Repository\ChatRepository;
use JeroenFrenken\Chat\Repository\UserRepository;

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
            return new JsonResponse([
                [
                    'field' => 'id',
                    'message' => 'Chat not found'
                ]
            ], Response::NOT_FOUND);
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
        } catch (\Exception $exception) {
            return new JsonResponse([
                [
                    'field' => 'input',
                    'message' => 'Json not right formatted'
                ]
            ], Response::BAD_REQUEST);
        }

        $response = $this->_validator->validate('chat', $data);

        if (!$response->isStatus()) return new JsonResponse($response, Response::BAD_REQUEST);

        /** @var User $recipient */
        $recipient = $this->_userRepository->getUserByUsername($data['recipient']);

        if ($recipient === null) {
            return new JsonResponse([
                [
                    'field' => 'recipient',
                    'message' => 'Recipient not found'
                ]
            ], Response::NOT_FOUND);
        }

        if ($this->_user->getId() === $recipient->getId()) {
            return new JsonResponse([
                [
                    'field' => 'recipient',
                    'message' => 'Recipient can not be the owner of the chat'
                ]
            ], Response::BAD_REQUEST);
        }

        $chat = new Chat();
        $chat->setOwner($this->_user);
        $chat->setRecipient($recipient);

        $success = $this->_chatRepository->createChat($chat);

        if ($success) {
            return new JsonResponse([]);
        } else {
            return new JsonResponse([
                [
                    'field' => 'unknown',
                    'message' => 'Chat creation failed'
                ]
            ], Response::BAD_REQUEST);
        }
    }

    public function deleteChat(string $id)
    {

        $success = $this->_chatRepository->deleteChatByChatIdAndUserId(intval($id), $this->_user->getId());

        if ($success) {
            return new JsonResponse([]);
        } else {
            return new JsonResponse([
                [
                    'field' => 'unknown',
                    'message' => 'Chat could not be deleted'
                ]
            ], Response::BAD_REQUEST);
        }
    }

}
