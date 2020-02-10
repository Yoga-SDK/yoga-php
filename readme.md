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
    'controller' => 'App\Http\Controllers\AuthController',
    'enable_create_user' => true,
    'create_user_rules' => [
      'name' => 'required|min:2',
      'email' => 'required|email',
      'password' => 'required|min:6|max:16'
    ],
    'enable_update_user' => true,
    'update_user_rules' => [
      'name' => 'required|min:2',
      'email' => 'required|email|unique:users,email',
      'password' => 'nullable|min:6|max:16'
    ]
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

## Create user
To create a new user you will need to register the configuration on the config file and add the function on the IdentityAndPassword file.
#### **src/Auth/IdentityAndPassword.php**
``` php
*****
function createUser(Request $request)
  {
    if (!config('yoga.auth.enable_create_user')) {
      return Yoga::reject(__('Create users not enable'));
    }

    // Validar requisição

    $validatedData = $request->validate(
      config('yoga.auth.create_user_rules', [])
    );

    $validatedData['password'] = Hash::make($validatedData['password']);

    // Criar novo usuario

    $user = $this->authenticable::create($validatedData);

    // Logar o novo usuario

    $user->createToken();

    return Yoga::resolve([
      'access_token' => $user->getAccessToken(),
      'token_type' => 'Bearer',
      'expires_at' => date('Y-m-d H:i:s', strtotime('+1 day'))
    ]);

  }
*******
```

## Update user
To create a new user you will need to register the configuration on the config file and add the function on the IdentityAndPassword file.
#### **src/Auth/IdentityAndPassword.php**
``` php
*****
function updateProfile(Request $request) {

    // Verica se possui permissão para editar
    if (!config('yoga.auth.enable_update_user')) {
      return Yoga::reject(__('Update users not enable'));
    }
    $user = Auth::guard(config('yoga.auth.guard'))->user();

    // Valida os dados
    $validatedData = $request->validate(
      collect(config('yoga.auth.update_user_rules', []))->map(function($rule) use ($user) {
        return join(collect(explode('|', $rule))->map(function($rule) use ($user) {
          if (strpos($rule, 'unique:') !== false) {
            return $rule.','.$user->id;
          } else return $rule;
        })->toArray(), '|');
      })->toArray()
    );
    if ($validatedData['password']) {
      $validatedData['password'] = Hash::make($validatedData['password']);
    }

    // Edita os dados
    $user->update($validatedData);

    return Yoga::resolve($user);
  }
*******
```

Thats all. Your yoga clients can now access your models using yoga client.

# CORS issues

If your Yoga server is running in a domain different than your Yoga client, you may have some CORS issues. To solve this, we recomend the use of [spatie/cors library](https://github.com/spatie/laravel-cors)
