<?php

namespace Yoga\Controllers;

use Yoga\Yoga;
use Illuminate\Http\Request;

class YogaServerController
{
  public $resources = [];

  public $callables = [];

  function __construct()
  {
    $this->resources = config('yoga.resources');
    $this->callables = array_merge($this->resources, config('yoga.whitelist', []));
  }

  function index(Request $request)
  {
    try {
      $root = $this->resources[$request->resource];
      $result = collect($request->executionList)->reduce(
      function($previousResult, $nextInstruction) {
          if (in_array($nextInstruction['method'], $this->callables)) {
            return call_user_func_array([$previousResult, $nextInstruction['method']], $nextInstruction['params']);
          }
      }, $root);
      return Yoga::resolve($result);
    } catch (\Throwable $e) {
        return Yoga::reject($e->getMessage());
    }
  }
}

// End of file
