<?php

return [
    'defaults' => [
        'guard' => 'admin',
        'passwords' => 'admins',
    ],
    'guards' => [
        'admin' => [
            'driver' => 'jwt',
            'provider' => 'admins',
        ],
        'member' => [
            'driver' => 'jwt',
            'provider' => 'members',
        ],
    ],
    'providers' => [
        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],
        'members' => [
            'driver' => 'eloquent',
            'model' => App\Models\Member::class,
        ]
    ],
    'passwords' => [
        'admins' => [
            'provider' => 'admins',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
        'members' => [
            'provider' => 'members',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],
    'password_timeout' => 10800,
];
