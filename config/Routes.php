<?php

return [
    [
        'url' => '/user',
        'controller' => 'JeroenFrenken\Chat\Controller\UserAuthenticatedController::getUser',
        'methods' => [
            'GET', 'OPTIONS'
        ],
        'auth' => true,
    ],
    [
        'url' => '/user',
        'controller' => 'JeroenFrenken\Chat\Controller\UserController::createUser',
        'methods' => [
            'POST', 'OPTIONS'
        ],
        'auth' => false,
    ],
    [
        'url' => '/authenticate',
        'controller' => 'JeroenFrenken\Chat\Controller\UserController::authenticateUser',
        'methods' => [
            'POST', 'OPTIONS'
        ],
        'auth' => false,
    ],
    [
        'url' => '/chat',
        'controller' => 'JeroenFrenken\Chat\Controller\ChatController::getChats',
        'methods' => [
            'GET', 'OPTIONS'
        ],
        'auth' => true,
    ],
    [
        'url' => '/chat',
        'controller' => 'JeroenFrenken\Chat\Controller\ChatController::createChat',
        'methods' => [
            'POST', 'OPTIONS'
        ],
        'auth' => true,
    ],
    [
        'url' => '/chat/:id',
        'controller' => 'JeroenFrenken\Chat\Controller\ChatController::getChat',
        'methods' => [
            'GET', 'OPTIONS'
        ],
        'auth' => true,
    ],
    [
        'url' => '/chat/:id',
        'controller' => 'JeroenFrenken\Chat\Controller\ChatController::deleteChat',
        'methods' => [
            'DELETE', 'OPTIONS'
        ],
        'auth' => true,
    ],
    [
        'url' => '/chat/:id/message',
        'controller' => 'JeroenFrenken\Chat\Controller\MessageController::getMessages',
        'methods' => [
            'GET', 'OPTIONS'
        ],
        'auth' => true,
    ],
    [
        'url' => '/chat/:id/message',
        'controller' => 'JeroenFrenken\Chat\Controller\MessageController::createMessage',
        'methods' => [
            'POST', 'OPTIONS'
        ],
        'auth' => true,
    ]
];
