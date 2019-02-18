<?php

namespace Walksoft\Users;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class UsersServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var  bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return  void
     */
    public function boot()
    {
        // Get namespace
        $nameSpace = $this->app->getNamespace();

        AliasLoader::getInstance()->alias('UsersAppController', $nameSpace . 'Http\Controllers\Controller');

        // Routes
        $this->app->router->group(['namespace' => $nameSpace . 'Http\Controllers', 'middleware'=>['web', 'auth'], 'prefix'=> config('adminlte.dashboard_url')], function () {
            require __DIR__ . '/../routes/web.php';
        });

        // Load Views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'Users');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'Users');
    }

    public function register()
    {
    }

}
