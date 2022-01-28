<?php

namespace Lar\Layout\Middleware;

use App;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Layout;

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
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     * @throws Exception
     */
    public function handle($request, Closure $next)
    {
        App::setLocale(Layout::nowLang());

        return $next($request);
    }
}
