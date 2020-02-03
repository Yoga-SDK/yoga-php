<?php

namespace Yoga\Controllers;

use Yoga\Yoga;
use Illuminate\Http\Request;

class YogaServerController
{
  public $resources = [];

  function __construct()
  {
    $this->resources = config('yoga.resources');
  }

  function index(Request $request)
  {
    try {
      $root = $this->resources[$request->resource];
      $result = collect($request->executionList)->reduce(
      function($previousResult, $nextInstruction) {
          return call_user_func_array([$previousResult, $nextInstruction['method']], $nextInstruction['params']);
      }, $root);
      return Yoga::resolve($result);
    } catch (\Throwable $e) {
        return Yoga::reject($e->getMessage());
    }
  }
}

// End of file
