# laravel-admin-ext-sso

## install

`composer require dm-laravel-admin-ext/sso`

## configure

### publish config.php and migration

`php artisan vendor:publish --provider="DM\SSO\SSOServiceProvider"`

### migrate:

`php artisan migrate`

this command will create oss tables to authorize.

### you can create sso client through command

`php artisan sso:create`

### 

add middleware to `Http/kernel.php`

```php

protected $middlewareGroups = [
    'web' => [
        ...
        // sso 
        \DM\SSO\Http\Middleware\SSOLoginWithTicket::class,
    ],
```

## usage

### Get redirect url to client

```php

$url = SSOController::loginTo($app_id);

```

