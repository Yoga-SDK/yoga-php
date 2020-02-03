<?php

namespace Yoga\Resources;

use Auth;

class Me
{
  static function boot($resource)
  {
    $resources = config('yoga.resources');
    $resource  = $resources[$resource];
    return Auth::guard(config('yoga.auth.guard'))->user()->ownables($resource);
  }
}
