<?php

namespace DM\SSO;

use Encore\Admin\Extension;
use Illuminate\Support\Facades\Route;

class SSO extends Extension
{
    public $name = 'sso';

    public static function web_routes($callback){
        $attributes = array_merge(
            [
                'prefix'     => config('admin.route.prefix'),
                'middleware' => ['web'],
            ],
            static::config('route', [])
        );

        Route::group($attributes, $callback);
    }
}