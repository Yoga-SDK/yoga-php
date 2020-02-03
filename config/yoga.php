<?php

return [
  'auth' => [
    'guard' => 'api',
    'users_table' => 'users',
    'api_tokens'  => true,
    'controller' => ''
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
  'resources' => []
];

// End of file
