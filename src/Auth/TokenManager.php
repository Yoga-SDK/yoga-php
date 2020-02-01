<?php

namespace Yoga\Auth;

use Str;

trait TokenManager
{
  function getTokenColumn() {
    return config('yoga.auth.token_column', 'api_token');
  }

  function createToken()
  {
    $this->{$this->getTokenColumn()} = hash('sha256', Str::random(80));
    $this->save();
  }

  function getAccessToken()
  {
    return $this->{$this->getTokenColumn()};
  }
}

// End of file
