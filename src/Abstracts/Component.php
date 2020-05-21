<?php

namespace Lar\Layout\Abstracts;

use Lar\Developer\Core\Traits\Eventable;
use Lar\Layout\Core\ComponentStatic;
use Lar\Layout\Traits\DataTrait;
use Lar\Layout\Traits\LjsDataAttributes;
use Lar\Tagable\Core\HTML5Library;

/**
 * Class Component
 * @package Lar\Layout\Abstracts
 */
class Component extends ComponentStatic
{
    use LjsDataAttributes, Eventable, DataTrait;

    /**
     * @var array
     */
    protected $props = [];

    /**
     * @var array
     */
    protected $apply = [];

    /**
     * Component constructor.
     *
     * @param array $params
     */
    public function __construct(...$params)
    {
        $this->toExecute('makeDataEvents');

        parent::__construct($params);

        foreach ($this->apply as $item) {

            if (is_string($item)) {

                custom_closure_call([$this, $item]);
            }

            else if (is_array($item) || $item instanceof \Closure) {

                custom_closure_call($item);
            }
        }
    }

    /**
     * Make data events
     */
    protected function makeDataEvents () {

        if (!$this->only_content) {

            $this->setDatas($this->data);
        }
    }

    /**
     * Add new child
     *
     * @param string $element
     * @param array $arguments
     * @return $this
     * @throws \Exception
     */
    public function add(string $element, array $arguments = [])
    {
        if (!$this->isElement())
            throw new \Exception("Element not initialized! Clall \"initTag\"");

        $class = $this->getClassNameByTag($element);

        $class::$_tmp_handler_name = $this->handler_name;

        /** @var Component $new */
        $new = new $class(...$arguments);

        $this->appEnd($new);

        return $new;
    }


    /**
     * @param string $element
     * @param mixed ...$props
     * @return Component
     */
    public function tag(string $element, ...$props)
    {
        /** @var Component $new */
        $new = new Component(...$props);

        $new->initTag($element);

        $this->appEnd($new);

        return $new;
    }

    /**
     * Get class name by tag name
     *
     * @param string $element
     * @return string
     */
    public static function getClassNameByTag(string $element)
    {
        if (isset(HTML5Library::$tags_extends[$element])) {

            return HTML5Library::$tags_extends[$element];
        }

        if ($element == 'use')
            $element = "svg" . $element;

        if (
            $element == 'object' ||
            $element == 'var'
        )
            $element = "tag" . $element;

        return "Lar\\Layout\\Tags\\" . strtoupper($element);
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function __toString()
    {
        return $this->render();
    }
}
