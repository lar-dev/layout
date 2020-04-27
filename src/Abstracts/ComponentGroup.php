<?php

namespace Lar\Layout\Abstracts;

use Illuminate\Contracts\Support\Renderable;

/**
 * Class ComponentGroup
 *
 * @package Lar\Layout\Abstracts
 */
class ComponentGroup implements Renderable {

    /**
     * Having component list
     *
     * @var array
     */
    static $components = [];

    /**
     * Injected component list
     *
     * @var array
     */
    protected $injected = [];

    /**
     * @param $name
     * @param $arguments
     * @return $this|Component
     */
    public function inject($name, ...$arguments)
    {
        if (isset(static::$components[$name])) {

            $inject = new static::$components[$name](...$arguments);

            $this->injected[] = $inject;
        }

        return $this;
    }

    /**
     * @param $name
     * @param $arguments
     * @return $this|Component
     */
    public function __call($name, $arguments)
    {
        if (isset(static::$components[$name])) {

            $inject = new static::$components[$name](...$arguments);

            $this->injected[] = $inject;

            return $inject;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * Add component in to having component list
     *
     * @param string $name
     * @param string $object
     */
    public static function addComponent(string $name, string $object)
    {
        static::$components[$name] = $object;
    }

    /**
     * Add component collection in to having component list
     *
     * @param array $array
     */
    public static function addComponentCollection(array $array = [])
    {
        static::$components = array_merge(static::$components, $array);
    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        return implode('', array_map(function (Renderable $r) { return $r->render(); }, $this->injected));
    }
}
