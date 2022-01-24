<?php

namespace Lar\Layout\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Lar\Layout\Abstracts\LayoutComponent;
use Lar\Layout\Layout;

class LayoutMiddleware
{
    /**
     * @var array
     */
    protected static $on_load = [];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $name
     * @return mixed
     * @throws \Exception
     */
    public function handle($request, Closure $next, $name = '')
    {
        if ($request->ajax() && ! $request->pjax() || ! $request->isMethod('get')) {
            return $next($request);
        }

        $this->run_on_load();

        $component = static::makeLayoutComponent($name);

        if (! $component instanceof LayoutComponent) {
            throw new \Exception('The layout mast be a [LayoutComponent]!');
        }

        Layout::$selected_layout = $component;

        /** @var \Illuminate\Http\Response $response */
        $response = $next($request);

        $component->setInContent($response->getContent());

        if (! $response->exception && ! $response instanceof RedirectResponse) {
            $response->setContent('');
        }

        return $response;
    }

    /**
     * @param string $name
     * @return LayoutComponent|mixed
     * @throws \Exception
     */
    public static function makeLayoutComponent(string $name = '')
    {
        $component = static::getLayoutComponent($name);

        return new $component();
    }

    /**
     * @param string $name
     * @return string
     * @throws \Exception
     */
    public static function getLayoutComponent(string $name = '')
    {
        if (Layout::$collect && Layout::$collect->has($name)) {
            return Layout::$collect->get($name);
        } elseif (! empty($name) && class_exists($class = 'App\\Layouts\\'.ucfirst(Str::camel(Str::slug($name, '_'))))) {
            return $class;
        } elseif (class_exists($name)) {
            return $name;
        } else {
            return LayoutComponent::class;
        }
    }

    /**
     * @return $this
     */
    public function run_on_load()
    {
        foreach (static::$on_load as $item) {
            call_user_func($item, $this);
        }

        return $this;
    }

    /**
     * @param  Closure|array  $call
     */
    public static function onLoad($call)
    {
        if (is_embedded_call($call)) {
            static::$on_load[] = $call;
        }
    }
}
