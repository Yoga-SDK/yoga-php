<?php

return [
  'auth' => [
    'enabled' => true,
    'guard' => 'api',
    'users_table' => 'users',
    'api_tokens'  => true,
    'controller' => '\Yoga\Controllers\AuthController',
    'model' => \App\User::class
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
