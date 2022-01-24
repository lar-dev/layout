<?php

namespace Lar\Layout\Middleware;

use Closure;

/**
 * Class DomMiddleware.
 *
 * @package Lar\Layout\Middleware
 */
class LanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     * @throws \Exception
     */
    public function handle($request, Closure $next)
    {
        \App::setLocale(\Layout::nowLang());

        return $next($request);
    }
}
