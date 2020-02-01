<?php

namespace Yoga\Ownership;

trait Owner
{
  function ownables($ownableType)
  {
    return $this->morphedByMany($ownableType, 'ownable', 'ownables', 'owner_id', 'ownable_id');
  }
}

// End of file
