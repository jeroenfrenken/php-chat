<?php

return [
    'recipient' => [
        /*
         * minimal 2 characters with max 40
         * a-z Characters allowed
         * A-Z Characters allowed
         * 0-9 Allowed
         * A special character . is also allowed
         */
        'regex' => "/^[a-zA-Z0-9\.]{2,40}$/m",
        'message' => "Recipient not valid",
        'required' => true,
    ],
];
