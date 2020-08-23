<?php

namespace Lar\Layout\Components;

use Illuminate\Contracts\Support\Renderable;
use Lar\Layout\Tags\SCRIPT;

/**
 * Class LjsScripts
 * @package Lar\Layout\Components
 */
class LjsScripts implements Renderable
{
    /**
     * @var array
     */
    private $plugins;

    /**
     * Script constructor.
     *
     * @param  array  $plugins
     */
    public function __construct(array $plugins = [])
    {
        $this->plugins = $plugins;
    }

    /**
     * @return string
     */
    public function render()
    {
        $js_path = \App::isLocal() && !is_link(base_path('lar')) ? 'js.dev' : 'js';

        if (\App::isLocal() && request()->has('dev')) {

            $js_path = 'js.dev';
        }

        $scripts = [
            SCRIPT::create()->setType('text/javascript')->asset("ljs/{$js_path}/ljs.js")->render()
        ];

        $first = [];

        foreach ($this->plugins as $plugin) {

            $scr = SCRIPT::create()->setType('text/javascript')->asset("ljs/{$js_path}/plugins/{$plugin}.js")->render();

            if ($plugin === 'jquery') $first[] = $scr;
            else $scripts[] = $scr;
        }

        return implode("", array_merge($first, $scripts));
    }

    /**
     * @param  array  $plugins
     * @return string
     */
    public static function create(array $plugins = [])
    {
        return (new static($plugins))->render();
    }
}
