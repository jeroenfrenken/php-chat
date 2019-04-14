<?php

return [
    'message' => [
        /*
         * minimal 1 characters with max 250
         * a-z Characters allowed
         * A-Z Characters allowed
         * 0-9 Allowed
         * Space is allowed
         */
        'regex' => "/^[a-zA-Z0-9 ]{1,250}$/m",
        'message' => "Message not valid",
        'required' => true,
    ]
];
