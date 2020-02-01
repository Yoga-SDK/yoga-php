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

  static function reject($data)
  {
    return response(['data' => $data], 400);
  }

  static function resolve($data)
  {
    return response(['data' => $data], 200);
  }

  static function registerAuthRoutes()
  {
    $attributes = [
      'prefix' => config('yoga.routes.prefix'),
      'middleware' => config('yoga.routes.middlewares')
    ];

    app('router')->group($attributes, function($router) {
      $controller = config('yoga.auth.controller').'@';

      $router->post('/auth/login', $controller.'doLogin');
    });
  }
}

// End of file
