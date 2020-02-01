<?php

namespace Yoga\Ownership;

trait Ownable
{

  static function bootOwnable()
  {
    static::saved(function($model) {
      $owner = $model->getOwnerBy();
      if ($owner) {
        $model->owner()->save($owner);
      }
    });
  }

  function owner()
  {
    return $this->morphToMany(static::$ownerClass, 'ownable', 'ownables', 'ownable_id', 'owner_id')->withTimestamps();
  }
}

// End of file
