<?php

namespace DM\SSO;

use Illuminate\Support\ServiceProvider;
use DM\SSO\Console\Commands\CreateSsoClient;

class SSOServiceProvider extends ServiceProvider
{

    /**
     * {@inheritdoc}
     */
    public function boot(SSO $extension)
    {
        if (! SSO::boot()) {
            return ;
        }

        // 加载配置
        $this->publishes([__DIR__ . '/../config/' => config_path()]);

        // 迁移文件
        $this->publishes([__DIR__ . '/../database/' => database_path()]);

        // 命令
        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateSsoClient::class,
            ]);
        }

        if ($views = $extension->views()) {
            $this->loadViewsFrom($views, 'sso');
        }

        if ($this->app->runningInConsole() && $assets = $extension->assets()) {
            $this->publishes(
                [$assets => public_path('vendor/laravel-admin-ext/sso')],
                'sso'
            );
        }

        $this->app->booted(function () {
            SSO::web_routes(__DIR__.'/../routes/web.php');
        });
    }
}