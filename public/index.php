<?php

require_once __DIR__ . '/../vendor/autoload.php';
$routesConfig = require_once __DIR__ . '/../config/Routes.php';
$databaseConfig = require_once __DIR__ . '/../config/Database.php';
// Import the validator related config files
$userValidation = require_once __DIR__ . '/../config/Validation/User.php';

/*
 * Build the kernel and start it
 */
$kernel = new JeroenFrenken\Chat\Kernel([
    'routes' => $routesConfig,
    'database' => $databaseConfig,
    'validation' => [
        'user' => $userValidation
    ]
]);
$kernel->run();
