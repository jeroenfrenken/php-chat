<?php

return [
    'token' => [
        /*
         * minimal 128 characters with max 128
         * a-z Characters allowed
         * A-Z Characters allowed
         * 0-9 Allowed
         */
        'regex' => "/^[a-zA-Z0-9]{128,128}$/m",
        'message' => "Token not valid",
        'required' => true,
    ],
];
