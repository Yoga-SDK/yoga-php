<?php

return [
  'auth' => [
    'enabled' => true,
    'guard' => 'api',
    'users_table' => 'users',
    'api_tokens'  => true,
    'controller' => '\Yoga\Controllers\AuthController',
    'model' => \App\User::class,
    'enable_create_user' => true,
    'create_user_rules' => [
      'name' => 'required|min:2',
      'email' => 'required|email|unique:users,email',
      'password' => 'required|min:6|max:16'
    ],
    'enable_update_user' => true,
    'update_user_rules' => [
      'name' => 'required|min:2',
      'email' => 'required|email|unique:users,email',
      'password' => 'nullable|min:6|max:16'
    ]
  ],
  'routes' => [
    'global' => [
      'prefix' => 'yoga',
      'middleware' => ['api'],
    ],
    'auth' => [
      'middleware' => ['api', 'auth:api']
    ],
    'guest' => [] 
  ],
  'resources' => [
    'me' => Yoga\Resources\Me::class
  ]
];

// End of file
