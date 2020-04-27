<?php

namespace Lar\Layout\Middleware;

use Closure;
use Lar\Layout\Core\LConfigs;
use Lar\Layout\Executor;

class ExecutorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param null $name
     * @param array $related
     * @return mixed
     * @throws \Exception
     */
    public function handle($request, Closure $next)
    {
        if (($request->ajax() || $request->get("_with_executor", false)) && !$request->pjax() && $request->has("_exec")) {

            /** @var Closure $executor */
            $executor = new Executor();

            $this->makeConfigs();

            return $executor($request);
        }

        return $next($request);
    }

    /**
     * Make configs in header
     */
    private function makeConfigs() {

        LConfigs::makeDefaults();

        LConfigs::add('last_executed', time());

        foreach (LConfigs::$list as $key => $item) {

            header("{$key}: {$item}");
        }
    }
}
