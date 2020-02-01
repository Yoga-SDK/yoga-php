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
}

// End of file
