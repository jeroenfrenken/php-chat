<?php
return [
    [
        'url' => '/user',
        'controller' => 'JeroenFrenken\Chat\Controller\UserController::getUser',
        'methods' => [
            'GET', 'OPTIONS'
        ]
    ],
    [
        'url' => '/user',
        'controller' => 'JeroenFrenken\Chat\Controller\UserController::createUser',
        'methods' => [
            'POST', 'OPTIONS'
        ]
    ],
    [
        'url' => '/auth',
        'controller' => 'JeroenFrenken\Chat\Controller\UserController::authenticateUser',
        'methods' => [
            'POST', 'OPTIONS'
        ]
    ],
    [
        'url' => '/chat',
        'controller' => 'JeroenFrenken\Chat\Controller\ChatController::getChats',
        'methods' => [
            'GET', 'OPTIONS'
        ]
    ],
    [
        'url' => '/chat',
        'controller' => 'JeroenFrenken\Chat\Controller\ChatController::createChat',
        'methods' => [
            'POST', 'OPTIONS'
        ]
    ],
    [
        'url' => '/chat/:id',
        'controller' => 'JeroenFrenken\Chat\Controller\ChatController::getChat',
        'methods' => [
            'GET', 'OPTIONS'
        ]
    ],
    [
        'url' => '/chat/:id',
        'controller' => 'JeroenFrenken\Chat\Controller\ChatController::deleteChat',
        'methods' => [
            'DELETE', 'OPTIONS'
        ]
    ],
    [
        'url' => '/chat/:id/message',
        'controller' => 'JeroenFrenken\Chat\Controller\MessageController::getMessages',
        'methods' => [
            'GET', 'OPTIONS'
        ]
    ],
    [
        'url' => '/chat/:id/message',
        'controller' => 'JeroenFrenken\Chat\Controller\MessageController::createMessage',
        'methods' => [
            'POST', 'OPTIONS'
        ]
    ]
];
