<?php

return [
  'auth' => [
    'users_table' => 'users',
    'api_tokens'  => true,
    'controller' => ''
  ],
  'routes' => [
    'prefix' => 'yoga',
    'middlewares' => ['api']
  ]
];

// End of file
