<?php

namespace Lar\Layout\Traits;

use Lar\Layout\Abstracts\Component;
use Lar\Tagable\Tag;
use Lar\Tagable\Vue;

/**
 * Trait BladeDirectivesHelpers
 *
 * @package Lar\Layout\Traits
 */
trait BladeDirectivesHelpers
{
    /**
     * @param string|null $name
     * @param array|string|null $attributes
     * @return string
     * @throws \Exception
     */
    public static function createAttributeWatcher(string $name = null, ...$attributes)
    {
        $name = $name ? \Str::slug($name, "_") : count(static::$_attr_watchess);

        if (isset(static::$_attr_watches[$name])) {

            throw new \Exception("[{$name}] Such an identifier of watcher is already exists.");
        }

        static::$_attr_watches[$name] = [$name, $attributes];

        return "data-attr-watch=\"{$name}\"";
    }

    /**
     * @param string|int $name
     * @return string
     */
    public static function createLiveTag($name = null)
    {
        $name = $name ? \Str::slug($name, "_") : count(static::$_lives);
        
        static::$_lives[] = $name;

        return "data-live=\"{$name}\"";
    }

    /**
     * @param string $component
     * @param mixed ...$props
     * @return string
     * @throws \Exception
     */
    public static function vueTagOpen(string $component, ...$props)
    {
        if (Tag::$components->has($component)) {

            $component = Tag::$components->get($component);

            $component = new $component(...$props);
        }

        else {

            $component = (new Vue())->initTag($component)->when($props);
        }

        /** @var Vue $component */
        static::$_last_vue_state[] = $component;

        $component->opened_mode = true;

        return $component->render();
    }

    /**
     * @return string
     */
    public static function vueTagClose() {

        $last = \Arr::last(static::$_last_vue_state);

        if ($last instanceof Component) {

            $return = $last->element_closer();

            unset(static::$_last_vue_state[array_key_last(static::$_last_vue_state)]);

            return $return;
        }

        return "";
    }
}
