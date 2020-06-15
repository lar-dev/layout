<?php

namespace Lar\Layout\Core;

use Lar\Layout\Tags\META;

/**
 * Class LConfigs
 * @package Lar\Layout\Core
 */
class LConfigs {

    /**
     * @var array
     */
    static $list = [];

    /**
     * @param string $name
     * @param $value
     */
    public static function add(string $name, $value)
    {
        if (is_array($value)) {

            $value = json_encode($value);
        }

        if ($value === true) {
            $value = 'true';
        } else if ($value === false) {
            $value = 'false';
        } else if ($value === null) {
            $value = 'null';
        }

        static::$list['lar-' . $name] = $value;
    }

    /**
     * @param  string  $name
     * @return bool
     */
    public static function has(string $name)
    {
        return isset(static::$list['lar-' . $name]);
    }

    /**
     * @param  string  $name
     * @return bool
     */
    public static function remove(string $name)
    {
        $name = 'lar-' . $name;

        if (isset(static::$list[$name])) {

            unset(static::$list[$name]);

            return true;
        }

        return false;
    }

    /**
     * Make defaults configs
     */
    public static function makeDefaults()
    {
        static::add('env', config('app.env'));
        static::add('token', csrf_token());
        static::add('locale', \App::getLocale());

        if ($route = \Route::current()) {

            static::add('uri', $route->uri);
            static::add('name', $route->getName());
            static::add('executed', array_search('exec', $route->action['middleware']) !== false);
        }
    }

    /**
     * @return string
     */
    public static function render()
    {
        static::makeDefaults();

        $configs = [];

        foreach (static::$list as $name => $content) {

            $configs[$name] = META::create(["name" => $name, "content" => $content])->render();
        }

        return implode("", $configs);
    }
}