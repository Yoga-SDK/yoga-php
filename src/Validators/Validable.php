<?php

namespace Yoga\Validators;

use Yoga\Yoga;
use Illuminate\Support\Facades\Validator;

trait Validable
{

  static function _yogaCallback($model, $method) {
    $globalRules = Yoga::callIfExists($model, 'globalRules', [], []);
    $specificRules = Yoga::callIfExists($model, $method, [], []);
    $allRules = array_merge($globalRules, $specificRules);
    $validator = Validator::make($model->getAttributes(), $allRules);
    if ($validator->fails()) {
      throw new \Error('Invalid attributes to your model');
    }
  }

  static function bootValidable()
  {
    static::creating(function($model) {
      static::_yogaCallback($model, 'creatingRules');
    });
    static::updating(function($model) {
      static::_yogaCallback($model, 'updatingRules');
    });
  }
}

// End of file
