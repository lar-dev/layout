<?php

namespace Lar\Layout;

use Closure;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Collection;
use Lar\Layout\Respond\AlertSystemsTrait;
use Lar\Layout\Respond\Core;
use Lar\Layout\Respond\DocTrait;
use Lar\Layout\Respond\jQueryDecoratorTrait;
use Lar\Layout\Respond\State;
use Lar\Layout\Respond\Systems;
use Lar\Layout\Respond\Vue;
use Lar\Tagable\Tag;

/**
 * Class Respond.
 *
 * @package Lar\Layout
 * @mixin RespondDoc
 */
class Respond extends Collection implements Renderable, Htmlable
{
    use Core,
        jQueryDecoratorTrait,
        AlertSystemsTrait,
        DocTrait,
        State,
        Systems,
        Vue;

    /**
     * @var bool|array
     */
    protected static $injects = false;

    /**
     * @var Tag|object|null
     */
    protected $parent;

    /**
     * Respond constructor.
     *
     * @param  Closure|array|static|null  $parent
     */
    public function __construct($parent = null)
    {
        if ($parent) {
            if (is_embedded_call($parent)) {
                call_user_func($parent, $this);
            } else {
                $this->parent = $parent;
            }
        }
    }

    /**
     * @return array|Respond|RespondDoc
     */
    public static function get_macro_names()
    {
        return array_keys(static::$macros);
    }

    /**
     * @param  Closure  $closure
     * @return $this|RespondDoc|mixed
     */
    public function do(Closure $closure)
    {
        $closure = Closure::bind($closure, $this, static::class);

        $closure($this);

        return $this;
    }

    /**
     * @return Tag|object|null
     */
    public function parent()
    {
        return $this->parent;
    }

    /**
     * Set cursor pointer in the parent tag.
     *
     * @return $this
     */
    public function pointer()
    {
        if ($this->parent instanceof Tag) {
            $this->parent->setStyle('cursor: pointer');
        }

        return $this;
    }

    /**
     * Put rule alias.
     *
     * @param $key
     * @param  null  $value
     * @return Collection|Respond
     */
    public function insert($key, $value = null)
    {
        return parent::put($key, $value);
    }

    /**
     * @param $data
     * @return $this
     */
    public function justMerge($data)
    {
        if ($data instanceof Arrayable) {
            $data = $data->toArray();
        }

        $this->items = array_merge($this->items, $data);

        return $this;
    }

    /**
     * Merge rules.
     *
     * @param  mixed  $data
     * @return $this|Collection
     */
    public function merge($data)
    {
        foreach ($data as $key => $value) {
            $this->put(
                preg_replace('/^([0-9\:]+)\:/', '', $key),
                $value
            );
        }

        return $this;
    }

    /**
     * Put rule.
     *
     * @param $key
     * @param  mixed  $value
     * @return $this|Collection
     */
    public function put($key, $value = null)
    {
        if ($this->parent && preg_match('/^\:.*/', $key) && $this->parent instanceof Tag) {
            $key = $this->parent->getHandlerName().$key;
        }

        return parent::put($this->count().':'.$key, $value);
    }

    /**
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (!isset($this->parent)) {
            return parent::__call($method, $parameters);
        } else {
            return $this->parent->{$method}(...$parameters);
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        return $this->toJson();
    }

    /**
     * @param  int  $options
     * @return string
     */
    public function toJson($options = JSON_UNESCAPED_UNICODE)
    {
        return parent::toJson($options);
    }

    /**
     * Get content as a string of HTML.
     *
     * @return string
     */
    public function toHtml()
    {
        return $this->toJson();
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->items;
    }
}
