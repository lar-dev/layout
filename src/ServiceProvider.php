<?php

namespace Lar\Layout;

use Illuminate\Support\ServiceProvider as ServiceProviderIlluminate;
use Lar\Layout\Commands\ComponentList;
use Lar\Layout\Commands\JaxList;
use Lar\Layout\Commands\MakeComponent;
use Lar\Layout\Commands\MakeJSExecutor;
use Lar\Layout\Commands\MakeJSWatcher;
use Lar\Layout\Commands\MakeLayout;
use Lar\Layout\Commands\MakeLjsProject;
use Lar\Layout\Commands\MakeVue;
use Lar\Layout\Middleware\CorsMiddleware;
use Lar\Layout\Middleware\DomMiddleware;
use Lar\Layout\Middleware\LanguageMiddleware;
use Lar\Layout\Middleware\LayoutMiddleware;
use Lar\Tagable\Tag;

/**
 * Class ServiceProvider.
 *
 * @package Lar\Layout
 */
class ServiceProvider extends ServiceProviderIlluminate
{
    /**
     * @var array
     */
    protected $commands = [
        MakeJSExecutor::class,
        MakeLjsProject::class,
        MakeComponent::class,
        ComponentList::class,
        JaxList::class,
        MakeLayout::class,
        MakeVue::class,
        MakeJSWatcher::class,
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'dom' => DomMiddleware::class,
        'layout' => LayoutMiddleware::class,
        'lang' => LanguageMiddleware::class,
        'cors' => CorsMiddleware::class,
    ];

    /**
     * Bootstrap services.
     *
     * @return void
     * @throws \Exception
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__.'/../config' => config_path()], 'lar-layout-config');
        }

        Tag::injectCollection(config('components', []));

        new BladeDirectives();

        if (Layout::$lang_select) {
            \App::setLocale(Layout::$lang_select);
        }
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/layout.php', 'layout'
        );

        if (config('layout.lang_mode', false)) {
            $this->makeLang();
        }

        $this->app->instance(Respond::class, Respond::glob());

        $this->registerRouteMiddleware();

        $this->commands($this->commands);
    }

    /**
     * Make language date.
     */
    protected function makeLang()
    {
        $segment = request()->segment(1);

        if ($segment && array_search($segment, config('layout.languages')) !== false) {
            \Cookie::queue(cookie()->forever('lang', $segment));
            Layout::$lang_select = $segment;
        }
    }

    /**
     * Register the route middleware.
     *
     * @return void
     */
    protected function registerRouteMiddleware()
    {
        // register route middleware.
        foreach ($this->routeMiddleware as $key => $middleware) {
            app('router')->aliasMiddleware($key, $middleware);
        }
    }
}
