<?php

namespace Lar\Layout\Respond;

use Lar\Layout\JaxCollection;
use Lar\Layout\Respond;

/**
 * Trait DocTrait
 *
 * @package Lar\Layout\Respond
 */
trait DocTrait
{
    /**
     * doc::title
     *
     * @param string $title
     * @return $this
     */
    public function title(string $title)
    {
        $this->put("doc::title", $title);

        return $this;
    }

    /**
     * doc::redirect
     *
     * @param  string  $url
     * @param  array  $parameters
     * @param  bool  $absolute
     * @return $this
     */
    public function redirect(string $url, $parameters = [], $absolute = true)
    {
        if (\Route::has($url)) {

            $url = route($url, $parameters, $absolute);
        }

        $this->put("doc::redirect", $url);

        return $this;
    }

    /**
     * doc::location
     *
     * @param  string  $url
     * @param  array  $params
     * @return $this
     */
    public function location(string $url, array $params = [])
    {
        $this->put("doc::location", $url, json_encode($params));

        return $this;
    }

    /**
     * doc::location
     *
     * @param string $route
     * @param array $parameters
     * @param bool $absolute
     * @return $this
     */
    public function route(string $route, $parameters = [], $absolute = true)
    {
        $this->put("doc::location", route($route, $parameters, $absolute));

        return $this;
    }

    /**
     * History back
     *
     * @return $this
     */
    public function back()
    {
        $this->put("doc::back");

        return $this;
    }

    /**
     * doc::reload
     *
     * @param string $selector
     * @return $this
     */
    public function reload()
    {
        $this->put("doc::reload");

        return $this;
    }

    /**
     * @param  string  $element
     * @param  int  $ms
     * @return $this
     */
    public function scrollTo($element = 'body', $ms = 1000)
    {
        $this->put("doc::scrollTo", [$element, $ms]);

        return $this;
    }

    /**
     * @param $handle
     * @return JaxCollection
     */
    public function jax($handle)
    {
        if ($this->has("doc::jax")) {

            $collect = $this->get("doc::jax");
        }

        else {

            $collect = collect();

            $this->put("doc::jax", $collect);
        }

        if ($collect->has($handle)) {

            $jax_collect = $collect->get($handle);
        }

        else {

            $jax_collect = new JaxCollection();

            $jax_collect->parent($this->parent);

            $collect->put($handle, $jax_collect);
        }


        return $jax_collect;
    }

    /**
     * @return $this
     */
    public function preventDefault()
    {
        $this->put("doc::preventDefault");

        return $this;
    }

    /**
     * @param $event
     * @return $this
     */
    public function dispatch_event($event)
    {
        $this->put("doc::dispatch_event", $event);

        return $this;
    }
}
