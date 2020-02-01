<?php

namespace Yoga;

class Yoga
{
  static function callIfExists($obj, $method, $params = [], $default = null)
  {
    if (method_exists($obj, $method)) {
      return call_user_func([$obj, $method], $params);
    }
    return $default;
  }

  static function reject($data, $status = 400)
  {
    return response(['data' => $data], $status);
  }

  static function resolve($data)
  {
    return response(['data' => $data], 200);
  }

  static function registerAuthRoutes()
  {
    $globalAttributes = config('yoga.routes.global');
    $authAttributes   = array_merge($globalAttributes, config('yoga.routes.auth', []));
    $guestAttributes  = array_merge($globalAttributes, config('yoga.routes.guest', []));
    $controller       = config('yoga.auth.controller').'@';

    app('router')->group($guestAttributes, function($router) use ($controller) {
      $router->post('/auth/login', $controller.'doLogin');
    });

    app('router')->group($authAttributes, function($router) use ($controller) {
      $router->post('/auth/refreshToken', $controller.'refreshToken');
    });
  }
}

// End of file
