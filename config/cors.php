<?php

return [
    'paths'                    => ['api/*', 'sanctum/csrf-cookie'], // Ensure 'sanctum/csrf-cookie' is included
    'allowed_methods'          => ['*'],
    'allowed_origins'          => ['http://localhost:8080', 'https://web.himalmajumder.xyz'], // Change this to match your frontend URL
    'allowed_origins_patterns' => [],
    'allowed_headers'          => ['*'],
    'exposed_headers'          => [],
    'max_age'                  => 0,
    'supports_credentials'     => true, // Important for cookies
];
