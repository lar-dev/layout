<?php

namespace Lar\Layout;

use Illuminate\Support\Collection;
use Lar\Layout\Abstracts\LayoutComponent;

/**
 * Class Layout.
 *
 * @package Lar\Layout
 */
final class Layout
{
    /**
     * @var LayoutComponent
     */
    public static $selected_layout;

    /**
     * Layout component collection.
     *
     * @var Collection
     */
    public static $collect;

    /**
     * @var string
     */
    public static $lang_select;

    /**
     * Injected file list.
     *
     * @var array
     */
    public static $injected_files = [];

    /**
     * @return LayoutComponent
     */
    public function current()
    {
        return self::$selected_layout;
    }

    /**
     * Registration component.
     *
     * @param string $name
     * @param \Closure|array|string $component
     * @throws \Exception
     */
    public static function registerComponent(string $name, $component)
    {
        if (! static::$collect) {
            static::$collect = new Collection(config('app.layouts', []));
        }

        if (is_embedded_call($component)) {
            static::$collect->put($name, $component);
        } else {
            throw new \Exception('Undefined type component');
        }
    }

    /**
     * Check has component or not.
     *
     * @param string $name
     * @return bool
     */
    public static function hasComponent(string $name)
    {
        return static::$collect->has($name);
    }

    /**
     * Inject collection from file.
     *
     * @param $file
     * @throws \Exception
     */
    public static function injectFile($file)
    {
        if (! is_file($file)) {
            throw new \Exception("File not found! $file");
        }

        $data = require $file;

        static::$injected_files[] = $file;

        if (! is_array($data)) {
            throw new \Exception('File data must be component array');
        }

        static::injectCollection($data);
    }

    /**
     * Inject collection in to component collection.
     *
     * @param array $collection
     */
    public static function injectCollection($collection = [])
    {
        if (! static::$collect) {
            static::$collect = new Collection(config('app.layouts', []));
        }

        if (is_array($collection) || $collection instanceof Collection) {
            static::$collect = static::$collect->merge($collection);
        }
    }

    /**
     * Component getter.
     *
     * @param string $name
     * @return mixed
     * @throws \Exception
     */
    public static function getComponent(string $name)
    {
        if (static::$collect->has($name)) {
            $component = static::$collect->get($name);

            if (is_embedded_call($component)) {
                return call_user_func($component);
            } elseif (is_string($component)) {
                return new $component;
            }
        } else {
            throw new \Exception("Component [{$name}] not found!");
        }
    }

    /**
     * Get request lang.
     *
     * @return array|string|null
     */
    public function nowLang()
    {
        $select = self::$lang_select;

        if (! $select && session()->has('lang')) {
            $lang = session()->get('lang');

            if (in_array($lang, config('layout.languages'))) {
                $select = $lang;
            }
        } elseif (! $select && request()->cookie('lang')) {
            $lang = request()->cookie('lang');

            if (in_array($lang, config('layout.languages'))) {
                $select = $lang;
            }
        }

        if (! $select) {
            $select = config('app.locale');
        }

        return $select;
    }
}
