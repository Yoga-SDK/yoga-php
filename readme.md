# Yoga PHP SDK (Alpha)
## Laravel SDK of Yoga

This project is still in alpha. Do not use this in production.

# Instalation

Open your project on terminal and run:
```bash
composer require starta/yoga
```

Then run this command to publish assets and configuration files
```bash
php artisan vendor:publish --provider="Yoga\YogaServiceProvider"
```

The default configuration looks like:
```php
<?php

return [
  'auth' => [
    'enabled' => true,
    'guard' => 'api',
    'users_table' => 'users',
    'api_tokens'  => true,
    'controller' => ''
  ],
  'routes' => [
    'global' => [
      'prefix' => 'yoga',
      'middleware' => ['api'],
    ],
    'auth' => [
      'middleware' => ['api', 'auth:api']
    ],
    'guest' => [] 
  ],
  'resources' => [
    'me' => Yoga\Resources\Me::class
  ]
];

// End of file

```

If want to use Yoga default api validation, you should run:
```bash
php artisan migrate
```
# Enable authentication
In order to let your Yoga client authenticate, you must tell your Yoga Server how to do so.
First, lets create a controller called *AuthController* inside your controllers folder. Then, you must add *IdentityAndPassword* trait to it and set the authenticable model of your application. In the example below, we will use the laravel default authentication:

#### **App\Http\Controllers\AuthController.php**
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController
{
  use \Yoga\Auth\IdentityAndPassword;

  public $authenticable;

  function __construct() {
    $this->authenticable = \App\User::class;
  }
}

// End of file

```

Then in your configuration file, sets the auth.controller to the actual authentication controller.
#### **config/yoga.php**
```php
  *****
  'auth' => [
    'enabled' => true,
    'guard' => 'api',
    'users_table' => 'users',
    'api_tokens'  => true,
    'controller' => 'App\Http\Controllers\AuthController'
  ],
  *******
```
Thats all, your authentication method should be running nice.

# Database module
To enable your Yoga clients access your models, you should register it as resources in your configuration file. In the example bellow, we created to models, *App\Post* and *App\Comment*, that are releated.
In your config file, register then like:
#### **config/yoga.php**
```php
  *****
  'resources' => [
    'me' => Yoga\Resources\Me::class,
    'posts' => App\Post::class,
    'comments' => App\Comment::class
  ]
  *******
```

Thats all. Your yoga clients can now access your models using yoga client.
