<?php

namespace Lar\Layout\Components;

use Illuminate\Contracts\Support\Renderable;

/**
 * Class LjsScripts.
 * @package Lar\Layout\Components
 */
class LjsStyles implements Renderable
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
     * @param  array  $plugins
     * @return string
     */
    public static function create(array $plugins = [])
    {
        return (new static($plugins))->render();
    }

    /**
     * @return string
     */
    public function render()
    {
        $links = [
            CSS::create()->asset('ljs/css/ljs.css')->render(),
        ];

        foreach ($this->plugins as $plugin) {
            $links[] = CSS::create()->asset("ljs/css/plugins/{$plugin}.css")->render();
        }

        return implode('', $links);
    }
}
