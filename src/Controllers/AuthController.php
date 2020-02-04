<?php

namespace Yoga\Controllers;

use Illuminate\Http\Request;

class AuthController
{
  use \Yoga\Auth\IdentityAndPassword;

  public $authenticable;

  function __construct() {
    $this->authenticable = config('yoga.auth.model');
  }
}

// End of file
