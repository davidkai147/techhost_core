<?php

return [
    'user_type' => [
        'sa' => 'SUPER_ADMIN',
        'ad' => 'ADMIN',
        'user' => 'USER'
    ],
    'guard' => [
        'sa' => 'super-admin',
        'ad' => 'admin',
        'user' => 'user'
    ],
    'encrypt_keyword' => env('ENCRYPT_KEYWORD')
];
