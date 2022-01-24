<?php

namespace Lar\Layout\Abstracts;

use Lar\Developer\Core\Traits\Eventable;
use Lar\Layout\Core\ComponentStatic;
use Lar\Layout\Tags\INPUT;
use Lar\Layout\Traits\AlpineInjectionTrait;
use Lar\Layout\Traits\DataTrait;
use Lar\Layout\Traits\LjsDataAttributes;
use Lar\Tagable\Core\HTML5Library;
use Lar\Tagable\Tag;

/**
 * Class Component.
 * @package Lar\Layout\Abstracts
 */
class Component extends ComponentStatic
{
    use LjsDataAttributes, Eventable, DataTrait, AlpineInjectionTrait;

    /**
     * @var Component
     */
    public static $last_component;

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
                embedded_call([$this, $item]);
            } elseif (is_embedded_call($item)) {
                embedded_call($item);
            }
        }
    }

    /**
     * Add hiddens inputs.
     *
     * @param array $hidden_datas
     */
    public function hiddens(array $hidden_datas)
    {
        foreach ($hidden_datas as $name => $value) {
            $this->appEnd(INPUT::create()->hidden($name, $value));
        }
    }

    /**
     * Make data events.
     */
    protected function makeDataEvents()
    {
        if (! $this->only_content) {
            $this->setDatas($this->data);
        }
    }

    /**
     * Add new child.
     *
     * @param string $element
     * @param array $arguments
     * @return $this
     * @throws \Exception
     */
    public function add(string $element, array $arguments = [])
    {
        if (! $this->isElement()) {
            throw new \Exception('Element not initialized! Clall "initTag"');
        }

        $class = $this->getClassNameByTag($element);

        $class::$_tmp_handler_name = $this->handler_name;

        /** @var Component $new */
        $new = new $class(...$arguments);

        static::$last_component = $new;

        $this->appEnd($new);

        return $new;
    }

    /**
     * If there is a component.
     *
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws \Exception
     */
    protected function if_there_is_a_component($name, $arguments)
    {
        $object = static::$components->get($name);

        $object::$_tmp_handler_name = $this->handler_name;

        /** @var Tag $newObj */
        $newObj = new $object(...$arguments);

        $this->appEnd($newObj);

        return $newObj;
    }

    /**
     * @param string $element
     * @param mixed ...$props
     * @return Component
     */
    public function tag(string $element, ...$props)
    {
        /** @var Component $new */
        $new = new self(...$props);

        $new->initTag($element);

        $this->appEnd($new);

        return $new;
    }

    /**
     * Get class name by tag name.
     *
     * @param string $element
     * @return string
     */
    public static function getClassNameByTag(string $element)
    {
        if (isset(HTML5Library::$tags_extends[$element])) {
            return HTML5Library::$tags_extends[$element];
        }

        if ($element == 'use') {
            $element = 'svg'.$element;
        }

        if (
            $element == 'object' ||
            $element == 'var'
        ) {
            $element = 'tag'.$element;
        }

        return 'Lar\\Layout\\Tags\\'.strtoupper($element);
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
