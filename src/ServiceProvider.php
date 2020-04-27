<?php

namespace Lar\Layout;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider as ServiceProviderIlluminate;
use Lar\EntityCarrier\Core\Entities\ClassEntity;
use Lar\Layout\Commands\ComponentList;
use Lar\Developer\Commands\Dump\GenerateHelper;
use Lar\Developer\Commands\Dump\GenerateRespondHelper;
use Lar\Layout\Commands\JaxList;
use Lar\Layout\Commands\MakeComponent;
use Lar\Layout\Commands\MakeJaxExecutor;
use Lar\Layout\Commands\MakeJSExecutor;
use Lar\Layout\Commands\MakeLayout;
use Lar\Layout\Commands\MakeVue;
use Lar\Layout\Commands\MakeVueProject;
use Lar\Layout\Middleware\CorsMiddleware;
use Lar\Layout\Middleware\DomMiddleware;
use Lar\Layout\Middleware\ExecutorMiddleware;
use Lar\Layout\Middleware\LanguageMiddleware;
use Lar\Layout\Middleware\LayoutMiddleware;
use Lar\Tagable\Tag;


/**
 * Class ServiceProvider
 *
 * @package Lar\Layout
 */
class ServiceProvider extends ServiceProviderIlluminate
{
    /**
     * @var array
     */
    protected $commands = [
        MakeJaxExecutor::class,
        MakeJSExecutor::class,
        MakeVueProject::class,
        MakeComponent::class,
        ComponentList::class,
        JaxList::class,
        MakeLayout::class,
        MakeVue::class
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        "dom" => DomMiddleware::class,
        "layout" => LayoutMiddleware::class,
        "exec" => ExecutorMiddleware::class,
        "lang" => LanguageMiddleware::class,
        "cors" => CorsMiddleware::class
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

        Executor::injectCollection(config('executors', []));

        new BladeDirectives();

        register_shutdown_function(function () {


        });

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
        $this->app->resolving(Respond::class, function()
        {
            return 1;
        });

        $this->mergeConfigFrom(
            __DIR__.'/../config/layout.php', 'layout'
        );

        if (config('layout.lang_mode', false)) {

            $this->makeLang();
        }

        if (!is_file(app()->bootstrapPath("lar_doc.php"))) {

            $this->createDocFile();
        }


        if (!class_exists('Lar\Layout\LarDoc')) {

            if (!is_file(app()->bootstrapPath("lar_doc.php"))) {

                include __DIR__ . '/lar_doc';
            }

            else {

                include app()->bootstrapPath("lar_doc.php");
            }
        }

        if (!is_file(app()->bootstrapPath("respond_doc.php"))) {

            $this->createRespondDocFile();
        }

        if (!class_exists('Lar\Layout\RespondDoc')) {

            include app()->bootstrapPath("respond_doc.php");
        }

        $this->app->instance(Respond::class, Respond::glob());

        $this->registerRouteMiddleware();

        $this->commands($this->commands);
    }

    /**
     * Make language date
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

    /**
     * @param \Closure|null $closure
     */
    public static function createDocFile(\Closure $closure = null)
    {
        $namespace = namespace_entity("Lar\Layout");

        $namespace->wrap("php");

        $namespace->class("LarDoc", function (ClassEntity $class) use ($closure) {

            $class->extend("\\Lar\\Tagable\\Tag");

            $globals = GenerateHelper::getGenerateClosures();

            foreach ($globals as $global) {

                $global($class);
            }

            if ($closure) {

                $closure($class);
            }

        });

        file_put_contents(app()->bootstrapPath("lar_doc.php"), $namespace->render());
    }

    /**
     * @param \Closure|null $closure
     */
    public static function createRespondDocFile(\Closure $closure = null)
    {
        $namespace = namespace_entity("Lar\Layout");

        $namespace->wrap("php");

        $namespace->class("RespondDoc", function (ClassEntity $class) use ($closure) {

            $globals = GenerateRespondHelper::getGenerateClosures();

            $class->extend(Collection::class);

            foreach ($globals as $global) {

                $global($class);
            }

            if ($closure) {

                $closure($class);
            }

        });

        file_put_contents(app()->bootstrapPath("respond_doc.php"), $namespace->render());
    }
}

