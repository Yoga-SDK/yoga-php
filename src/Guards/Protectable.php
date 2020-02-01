<?php

namespace Yoga\Guards;

use Yoga\Yoga;

trait Protectable
{
  static function bootProtectable()
  {
    static::creating(function($model) {
      if (!Yoga::callIfExists($model, 'canCreate', [$model])) {
        throw new \Error('Cannot create model: Permission denied.');
      }
    });
    static::retrieved(function($model) {
      if (!Yoga::callIfExists($model, 'canRead', [$model])) {
        throw new \Error('Cannot read model: Permission denied.');
      }
    });
    static::updating(function($model) {
      if (!Yoga::callIfExists($model, 'canUpdate', [$model])) {
        throw new \Error('Cannot read model: Permission denied.');
      }
    });
    static::deleting(function($model) {
      if (!Yoga::callIfExists($model, 'canDelete', [$model])) {
        throw new \Error('Cannot read model: Permission denied.');
      }
    });
  }
}

// End of file
