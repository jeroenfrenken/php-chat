<?php

require_once __DIR__ . '/../vendor/autoload.php';
$routesConfig = require_once __DIR__ . '/../config/Routes.php';
$databaseConfig = require_once __DIR__ . '/../config/Database.php';
$middlewareConfig = require_once __DIR__ . '/../config/Middleware.php';
// Import the validator related config files
$userValidation = require_once __DIR__ . '/../config/Validation/User.php';
$chatValidation = require_once __DIR__ . '/../config/Validation/Chat.php';
$tokenValidation = require_once __DIR__ . '/../config/Validation/Token.php';

/*
 * Build the kernel and start it
 */
$kernel = new JeroenFrenken\Chat\Kernel([
    'routes' => $routesConfig,
    'database' => $databaseConfig,
    'middleware' => $middlewareConfig,
    'validation' => [
        'user' => $userValidation,
        'token' => $tokenValidation,
        'chat' => $chatValidation
    ]
]);
$kernel->run();
